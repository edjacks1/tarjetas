<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller{

    public function __construct(Request $request){
        $this->request  = $request;
    }

    public function getAll(){
        return response()->json([
            'status' => true, 
            'data' => User::all()
        ]);
    }

    public function checkIfEmailExists(){

        $this->validate($this->request,[ 'email' => 'required|max:150']);

        if(User::where('id','!=',$this->request->id)->where('email','=',$this->request->email)->count() > 0){
            return response()->json([ 'status'=> TRUE ], 200);
        }else{
            return response()->json([ 'status'=> FALSE ], 200);
        }
    }

}
