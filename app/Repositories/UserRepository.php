<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function allUser()
    {
        return User::where('deleted', 0)
        ->where('role', 'user')
        ->get();
    }

    public function allStaff()
    {
        return User::where('deleted', 0)
        ->where('role', 'staff')
        ->get();
    }

    public function storeUser($data)
    {
        return User::create($data);
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function findUserByEmail($email)
    {
        return User::where(['email'=>$email])->first();
    }

    public function searchKeyword($query)
    {
        return Product::select('make', 'model')
        ->where(function($q) use ($query) {
            $q->where('make', 'LIKE', '%'.$query.'%')
                ->orWhere('model', 'LIKE', '%'.$query.'%');
        })
        ->where('deleted', 0)
        ->distinct()
        ->get();
    }

    public function searchProduct($data)
    {
        return Product::select('*')
        ->where('deleted', 0)
        ->whereRaw("CONCAT(make, ' ', model) = ?", [$data])
        ->get();
    }

    public function updateUser($data, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->role = $data['role'];
        if($data['image'] != ''){
            $user->image = $data['image'];
        }
        $user->phoneNum = $data['phoneNum'];
        $user->save();
    }

    public function edit_password($data, $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function password_reset($data)
    {
        $user = User::where('email', $data['email'])->first();
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->deleted = 1;
        $user->save();
    }
}
