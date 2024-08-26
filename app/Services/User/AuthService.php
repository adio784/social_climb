<?php

namespace App\Services\User;

use App\Enums\TokenTypeEnum;
use App\Models\PaymentGateway;
use App\Models\User;
use App\Notifications\AccountActivatedNotification;
use App\Notifications\PasswordResetNotification;
use App\Notifications\RegisterNotification;
use App\Services\GatewayService;
use App\Services\PaystackService;
use App\Services\MonnifyService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AuthService
{
    use ResponseTrait;
    private $monnify_contactCode, $monnify_bvnNumber;

    public function __construct(protected User $user, protected GatewayService $gatewayService, protected MonnifyService $monnifyService)
    {
        $this->monnify_contactCode = "5787668243";
        $this->monnify_bvnNumber = "22318673488";
    }

    public function register(array $data)
    {
        try {

            $ran = $data['phone'] . random_int(1000000000, 9999999999);
            $name = $data['first_name'] . ' ' . $data['last_name'];

            $virtualAccData = [
                "accountReference" => $ran,
                "accountName" => $name,
                "currencyCode" => "NGN",
                "contractCode" => "0616331411",
                "customerEmail" => $data['email'],
                "bvn" => "22318673488",
                "customerName" => $name,
                "getAllAvailableBanks" => false,
                "preferredBanks" => ["035"]
            ];
            $dvaResponse = $this->createVirtualAcc($virtualAccData);
            // return $dvaResponse->requestSuccessful;
            if ($dvaResponse->requestSuccessful == true) {
                $user = $this->user->create($data);
                $this->createActivation($user, TokenTypeEnum::EMAIL_VERIFICATION);
                $accountDetails = $dvaResponse->responseBody->accounts[0];
                $user->update([
                    'reference' => $dvaResponse->responseBody->accountReference,
                    'account_name' => $accountDetails->accountName,
                    'account_number' => $accountDetails->accountNumber,
                    'bank_name' => $accountDetails->bankName,
                ]);

                return $this->successResponse("User registered successfully. Please check your email to verify your account.", $user);
            }

            return $this->errorResponse("Failed to create virtual account.", $dvaResponse);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function login($data): JsonResponse
    {
        try {
            $user = $this->user->where('email', $data['email'])->first();
            if (!$user) {
                return $this->inputErrorResponse('Email address not recognized');
            }

            if (!Hash::check($data['password'], $user->password)) {
                return $this->inputErrorResponse("Invalid password");
            }
            if ($user && $this->checkActivation($user)) {
                // $token = $user->createToken(config('auth.key'), ['guard' => 'user'])->plainTextToken;
                $token = $user->createToken('Authentication token')->plainTextToken;
                $imageUrl = asset('storage/' . $user->profile_image);
                $user->profile_image = $imageUrl;
                return $this->successResponse("Login successful", compact('user', 'token'));
            } else {
                throw new \Exception("Please verify your email");
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    public function updateProfile($id, $data): JsonResponse
    {
        try {
            if (Hash::check($data['old_password'], auth()->user()->password)) {

                if (Hash::check($data['new_password'], auth()->user()->password)) {
                    return $this->inputErrorResponse("New password cannot be same as old password");
                } else {
                    $Data = ['password' => Hash::make($data['new_password'])];
                    $updated = DB::table('users')->where('id', $id)->update($Data);
                    if ($updated) {
                        return $this->successResponse("Update successful");
                    } else {
                        return $this->errorResponse("User not found or no changes made");
                    }
                }
            } else {
                return $this->inputErrorResponse("Incorrect old password");
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }


    public function uploadProfileImage($id, $filePath): JsonResponse
    {
        try {
            $user = DB::table('users')->where('id', $id)->first();

            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            DB::table('users')->where('id', $id)->update(['profile_image' => $filePath]);

            return $this->successResponse("Update successful", $user);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }


    public function createVirtualAcc(array $data)
    // : JsonResponse
    {
        // check which payment gateway is set
        if ($this->gatewayService->getActiveGateway()->name == 'Strowallet') {
            // Create virtual account using strowallet
            return $this->monnifyService->createVirtualAccount($data);
        } else if ($this->gatewayService->getActiveGateway()->name == 'Paystack') {
            // Create virtual account using strowallet
            return $this->monnifyService->createVirtualAccount($data);
        } else {
            // Create virtual account using stro wallet
            return $this->monnifyService->createVirtualAccount($data);
            // } catch (Exception $ex) {
            //     Log::error($ex->getMessage());
            //     Log::error($ex->getTraceAsString());
            //     return $this->errorResponse($ex->getMessage());
            // }
        }
    }


    public function createActivation($user, $type = TokenTypeEnum::EMAIL_VERIFICATION): void
    {

        $code = $this->generateCode();
        DB::table("operation_tokens")->insert([
            'user_id' => $user->id,
            'token' => $code,
            'type' => $type,
        ]);
        if ($type !== TokenTypeEnum::EMAIL_VERIFICATION) {
            $user->notify(new PasswordResetNotification($user, $code));
        } else {
            $user->notify(new RegisterNotification($user, $code));
        }
    }

    public function generateCode(): string
    {
        return mt_rand(100000, 999999);
    }

    /**
     * Check if the user is logged in
     * @return mixed
     */
    public function check()
    {
        $check = auth('sanctum')->check();
        if ($check) {
            return true;
        }
        return false;
    }

    /**
     * @param $user
     * @return bool
     * Check if user account has been verified
     */
    public function checkActivation($user): bool
    {
        $completed = $user->email_verified_at;
        if ($completed === null) {
            $this->createActivation($user);
            return false;
        }
        return true;
    }

    /**
     * @param $user
     * @return bool
     * Check if user account has been verified
     */


    public function createAuthToken($user)
    {
        return $user->createToken('api-token')->plainTextToken;
    }

    public function getCurrentUser()
    {
        $check = auth('sanctum')->check();
        if ($check) {

            $user = auth('sanctum')->user();
            $imageUrl = asset('storage/' . $user->profile_image);
            $user->profile_image = $imageUrl;
            return $user;
            // return auth('sanctum')->user();
        }
        return null;
    }

    public function profile()
    {
        return $this->getCurrentUser();
    }

    public function wallet()
    {
        return $this->getCurrentUser()->wallet_balance;
    }

    public function accountdetails()
    {
        return response()->json([
            'account_name' => $this->getCurrentUser()->account_name,
            'account_number' => $this->getCurrentUser()->account_number,
            'bank_name' => $this->getCurrentUser()->bank_name,
        ]);
    }
    /**
     * Log the user out of the application.
     * @return bool
     */
    public function logout()
    {
        $id = $this->getCurrentUser()->id;
        $user = DB::table('users')->where('id', $id)->first();
        $user->currentAccessToken()->delete();
        // $user->token()->revoke();
        if ($user) {
            return $this->successResponse('Logout Successful');
        }
        return $this->errorResponse("No Logged in Session");
    }

    public function deleteAccount()
    {
        DB::table('users')->where('id', $this->getCurrentUser()->id)->delete();
        return $this->successResponse('Account Deleted');
    }

    /**
     * Activate the given used id
     * @param int $userId
     * @param string $code
     * @return mixed
     */
    public function activate(array $data)
    {
        $code = $data['code'];
        $type = TokenTypeEnum::EMAIL_VERIFICATION;
        try {
            $codeModel = DB::table("operation_tokens")
                ->where('token', $code)
                ->where('completed', false)
                ->where('type', $type)
                ->first(['user_id', 'created_at', 'token']);
            // dd($codeModel->token);
            if ($codeModel && Carbon::parse($codeModel->created_at)) {
                // Token is valid and not expired
                DB::transaction(function () use ($codeModel) {
                    // Update the token to mark it as completed
                    DB::table("operation_tokens")
                        ->where('user_id', $codeModel->user_id)
                        ->where('token', $codeModel->token)
                        ->update([
                            'completed' => true,
                            'created_at' => Carbon::now() // Use updated_at for the update timestamp
                        ]);

                    // Update the user's email_verified_at field
                    $this->user->where('id', $codeModel->user_id)->update([
                        'email_verified_at' => Carbon::now(),
                    ]);
                });

                $user = $this->user->find($codeModel->user_id);
                $user->notify(new AccountActivatedNotification($user));
                return $this->successResponse("Account Verification Successful");
            } elseif ($codeModel) {
                // Token is either invalid or expired
                $userData = $this->user->find('id', $codeModel->user_id, []);
                $this->createActivation($userData);
                return $this->errorResponse(
                    "Unable to verify email. Either your account is already verified or an incorrect verification code was used. Please check your email for confirmation."
                );
            } else {
                // Token not found
                return false;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    function expires(): Carbon
    {
        return Carbon::now()->subMinutes(60); // Example expiration time of 15 minutes
    }

    public function removeExpired(): bool
    {
        $expires = $this->expires();

        DB::table("operation_tokens")
            ->where('completed', false)
            ->where('created_at', '>', $expires)
            ->delete();
        return true;
    }

    public function createPasswordReset(array $data)
    {
        try {
            $user = $this->user->where('email', $data['email'])->first();
            $this->createActivation($user, TokenTypeEnum::PASSWORD_RESET);
            return $this->successResponse('Password Reset request. Please check your email to reset your password');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function completeResetPassword(array $data)
    {
        try {
            $user = $this->user->where('email', $data['email'])->first();
            if (Hash::check($data['password'], $user->password)) {
                throw new Exception("Please enter another password");
            }

            $code_model = DB::table("operation_tokens")->where('token', $data['code'])
                ->where('completed', false)
                ->where('created_at', '>', $this->expires());
            if (!$code_model) {
                throw new Exception("Please check your login details");
            }
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
            DB::table("operation_tokens")
                ->where('token', $data['code'])
                ->update([
                    'completed' => true,
                    'updated_at' => Carbon::now()
                ]);

            if (!$code_model) {
                $userData = $this->user->where('email', $data['email'])->first();
                $userArrayData = [
                    'id' => $userData['id'],
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'email' => $userData['email']
                ];
                $this->createActivation(json_encode($userArrayData), TokenTypeEnum::EMAIL_VERIFICATION);

                return false;
            }

            return true;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse($ex->getMessage());
        }
    }
}
