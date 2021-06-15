<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterFormRequest extends Controller
{
    public $request;
    public function __construct(Request $request){
        $this->validate(
            $request, [
                'phone_number' => 'required',
                'first_name'   => 'required',
                'last_name'    => 'required',
                'password'     => 'required|min:6|confirmed',
                'email'        => 'required|unique:users'
            ]
        );
        $request->merge(['password' => Hash::make($request->password)]);
        $this->request = $request;
    }
}