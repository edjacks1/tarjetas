<?php

namespace App\Models;

use App\Traits\GenerarUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model{

    use GenerarUuid;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'phone_number', 
        'email', 
        'uuid',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
    function checkUser(array $user) : array{
        $authUser = $this->where('email','=', $user['email'])->first();
        if( is_null( $authUser ) ){
            return ['status' => FALSE];
        }else{
            if( $this->checkPassword($authUser, $user['password']) ){
                return ['status' => TRUE, 'data' => $authUser];
            }
            return ['status' => FALSE];
        }
    }
    private function checkPassword(User $user, string $password) : bool {
        return Hash::check( $password, $user->password);
    }
}