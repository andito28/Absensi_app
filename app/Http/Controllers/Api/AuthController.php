<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\profileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
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
        $user->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'posisi' => $request->posisi,
            'hp' => $request->hp,
            'password' =>  $user->password
        ]);

        return response()->json(['success' => $user], $this->successStatus);
    }

    public function updatePassword(Request $request){

        $user = User::where('id',Auth::user()->id)->first();

        if(Hash::check($request->password,$user->password)){

            $user->update([
                'nama' => $user->nama,
                'jenis_kelamin' => $user->jenis_kelamin,
                'posisi' => $user->posisi,
                'hp' => $user->hp,
                'password' =>   bcrypt($request->new_password)
            ]);
            return response()->json([
                'data' => $user,
                'message' => 'Berhasil Ganti password'
            ], $this->successStatus);

        }else{

            throw new HttpResponseException(response()->json([
                'message'   => 'Password Sebelumnya Tidak Sesuai',
            ],500));
        }
    }

}
