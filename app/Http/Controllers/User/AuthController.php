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
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use ResponseTrait;
    public function __construct(protected AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)//: JsonResponse
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
        $id = auth()->user()->id;
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'username'      => 'required|string|max:255',
            'phone'         => 'required|string|max:15',
            'email'         => 'required|string|email|max:255',
        ]);
        $data = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'username'      => $request->username,
            'phone'         => $request->phone,
            'email'         => $request->email,
        ];
        return $this->authService->updateProfile($id, $data);
    }

    public function profileImage(ProfileImageRequest $request)
    {
        $id = auth()->user()->id;
        // $request->validate([
        //     'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        return $this->authService->uploadProfileImage($id, $request->file('profile_image'));
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
        return $this->authService->wallet();
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
