<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\HistoryServices;
use App\Services\User\AuthService;
use App\services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function __construct(protected UserServices $userServices,
                                protected HistoryServices $historyServices,
                                protected AuthService $authService)
    {

    }

    public function index(Request $request)
    {
        $data = [
            'Users' => $this->userServices->allUsers()
        ];
        return view('control.all-users', $data);
    }

    public function admin(Request $request)
    {
        $data = [
            'Users' => $this->userServices->allAdmins()
        ];
        return view('control.all-admins', $data);
    }

    public function getUser(Request $request)
    {
        $data = [
            'User'  => $this->userServices->getUser($request->route('id')),
        ];
        return view('control.view-users', $data);
    }

    public function userHistory(Request $request)
    {
        $id = $request->route('id');
        $data = [
            'User'       => $this->userServices->getUser($id),
            'FHistories' => $this->historyServices->getUserFundHistory($id),
            'AHistories' => $this->historyServices->getUserAirtimeHistory($id),
            'DHistories' => $this->historyServices->getUserDataHistory($id),
            'BHistories' => $this->historyServices->getUserBillHistory($id),
            'CHistories' => $this->historyServices->getUserCableHistory($id),
            'SHistories' => $this->historyServices->getUserSocialHistory($id),
        ];
        return view('control.user-history', $data);
    }


    public function changeUserPassword(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:8',
        ]);
        $userId = $validated['user_id'];
        $password = bcrypt($validated['password']);
        $this->authService->updateProfile($userId, [ 'password'=>$password]);
        return response()->json(['message' => 'Password changed successfully.'], 200);
    }

    public function fundWallet(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);
        $this->userServices->fund_wallet($validated['user_id'], $validated['amount']);
        return response()->json(['message' => 'Wallet funded successfully.'], 200);
    }

    public function activate(Request $request)
    {
        $id = $request->route('id');
        $this->userServices->update($id, ['status'=>'active']);
        return back()->with(['message' => 'User successfully activated.'], 200);
        return response()->json(['message' => 'User successfully activated.'], 200);
    }

    public function deactivate(Request $request)
    {
        $id = $request->route('id');
        $this->userServices->update($id, ['status'=>'inactive']);
        return back()->with(['message' => 'User successfully deactivated.'], 200);
        return response()->json(['message' => 'User successfully deactivated.'], 200);
    }
}
