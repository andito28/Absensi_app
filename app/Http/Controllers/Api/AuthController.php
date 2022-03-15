<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['hp' => request('hp'), 'password' => request('password')])){
            $user = Auth::user();
            $success['id'] = $user->id;
            $success['hp'] = $user->hp;
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }


    public function logout(Request $request){
        if(Auth::check()){
            $user = Auth::user()->token();
            $user->revoke();
            return response()->json([
                'message' => 'Logout successfully',
            ],200);
        } else{
            return response()->json([
            'message' => 'Unable to Logout',
            ],500);
        }
    }

}
