<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserAuthRequest\ActivateAccountRequest;
use App\Http\Requests\UserAuthRequest\CompletePasswordResetRequest;
use App\Http\Requests\UserAuthRequest\LoginRequest;
use App\Http\Requests\UserAuthRequest\PasswordResetRequest;
use App\Http\Requests\UserAuthRequest\RegisterRequest;
use App\Services\User\AuthService;
use Illuminate\Support\Facades\Storage;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use ResponseTrait;
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request) //: JsonResponse
    {
        return $this->authService->register($request->validated());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request->validated());
    }

    public function verify(ActivateAccountRequest $request): JsonResponse
    {
        return $this->authService->activate($request->validated());
    }

    public function createPasswordReset(PasswordResetRequest $request): JsonResponse
    {
        return $this->authService->createPasswordReset($request->validated());
    }

    public function completeResetPassword(CompletePasswordResetRequest $request): JsonResponse
    {
        try {
            $this->authService->completeResetPassword($request->validated());
            return $this->successResponse('Password reset successful');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    public function profile()
    {
        return $this->authService->profile();
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'username'      => 'required|string|max:255',
            'phone'         => 'required|max:15|',
            'email'         => 'required|string|email|max:255',
        ]);
        $id = auth()->user()->id;
        $data = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'username'      => $request->username,
            'phone'         => $request->phone,
            'email'         => $request->email,
        ];
        return $this->authService->updateProfile($id, $data);
    }

    // public function profileImage(Request $request)
    // {
    //     // Validate the uploaded file
    //     $request->validate([
    //         'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     $id = auth()->user()->id;
    //     $user = auth()->user();

    //     // Handle the file upload
    //     if ($request->hasFile('profile_image')) {

    //         $file = $request->file('profile_image');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $filePath = 'profile_images/' . $fileName;

    //         // Store the file
    //         $file->storeAs('public', $filePath);

    //         // Delete the old profile image if exists
    //         // if ($user->profile_image) {
    //             Storage::delete('public/' . $user->profile_image);
    //         // }

    //         // Update the user's profile image in the database
    //         // $user->profile_image = $filePath;
    //         // $user->save();
    //         return $request->all();
    //         $this->authService->uploadProfileImage($id, $file);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Profile image uploaded successfully!',
    //             'file_path' => $filePath
    //         ], 200);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'No file uploaded!',
    //     ], 400);
    // }


    public function profileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {

            // return response()->json([
            //     'success' => true,
            //     'message' => 'File received!',
            //     'file_info' => $request->file('profile_image')->getClientOriginalName(),
            // ], 200);

            $fileName = Str::uuid() . "." . $request->file("profile_image")->extension();
            $filePath = $request->file("profile_image")->storeAs("profile_images", $fileName, "public");
            $id = auth()->user()->id;

            return $this->authService->uploadProfileImage($id, $filePath);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded!',
            ], 400);
        }
    }

    public function changePassword(Request $request)
    {
        $id = auth()->user()->id;
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        return $this->authService->updateProfile($id, $request->all());
    }

    public function wallet()
    {
        return response()->json([
            'account_balance' => $this->authService->wallet(),
        ]);
    }

    public function accountdetails()
    {
        return $this->authService->accountdetails();
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function deleteAccount()
    {
        return $this->authService->deleteAccount();
    }
}
