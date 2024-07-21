<?php

namespace App\services;

use App\Models\User;

class UserServices
{

    public function allUsers()
    {
        return User::where('role', 'user')->paginate(15);
    }

    public function allAdmins()
    {
        return User::where('role', 'admin')->get();
    }

    public function getUser($id)
    {
        return User::whereId($id)->first();
    }

    public function create(array $Data)
    {
        return User::create($Data);
    }

    public function update($id, array $Data)
    {
        return User::whereId($id)->update($Data);
    }

    public function delete($id)
    {
        return User::whereId($id)->delete();
    }

    public function disable($id)
    {
        return User::whereId($id)->update(['status'=>'inactive']);
    }

    public function activate($id)
    {
        return User::whereId($id)->update(['status'=>'active']);
    }

    public function fund_wallet($id, $wallet)
    {
        return User::whereId($id)->increment('wallet_balance', $wallet);
    }
}
