<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\profileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public $successStatus = 200;


    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['nama'] =  $user->nama;

        return response()->json(['success'=>$success], $this->successStatus);
    }

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

    public function getProfile(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function updateProfile(profileUpdateRequest $request){

        $user = User::where('id',Auth::user()->id)->first();

        if($request->password == null){
            $pass = $user->password;
        }else{
            $pass = bcrypt($request->password);
        }

        $user->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'posisi' => $request->posisi,
            'hp' => $request->hp,
            'password' => $pass
        ]);

        return response()->json(['success' => $user], $this->successStatus);
    }

}
