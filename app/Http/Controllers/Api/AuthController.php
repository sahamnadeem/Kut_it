<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateUserRequest;
use App\Notifications\SignupActivate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            if (auth()->user()->status_id != 1){
                return response()->json(['message'=>'User can not Login'], 401);
            }
            $token = auth()->user()->createToken('Web')->accessToken;
            return response()->json(['token' => $token,'user'=> Auth::user()->load('status','roles')], 200);
        } else {
            return response()->json(['error' => 'Login Credentials where wrong '], 401);
        }
    }
    public function aproval()
    {
        $barber = User::whereId(auth()->user()->id)->first();
        if($barber->is_barber && $barber->barber_verified_at){
            $data['is_barber'] = true;
        }else{
            $data['is_barber'] = false;
        }
        if($barber->services->count()>0){
            $data['services'] = true;
        }else{
            $data['services'] = false;
        }
        return $data;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'picture'=>'string',
            'age'=>'numeric|min:1|max:150',
            'phone_no'=>'required|numeric'
        ]);
        $user = User::create([
            'picture' => $request->picture,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60),
            'age'=>$request->age,
            'phone_no'=>$request->phone_no
        ]);
        $user->attachRole('client');
//        $user->notify(new SignupActivate($user));
        $token = $user->createToken('mobile')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
    public function user(Request $request){
        return response()->json($request->user());
    }

    public function updateuser(Request $request){
        if ($request->password){
            if(Hash::check($request->oldpassword, auth()->user()->getAuthPassword())){
                $request['password'] = bcrypt($request->password);
            }else{
                return response()->json([
                    'message' => 'Update Faild'
                ],504);
            }
        }
        Auth::user()->update($request->all());
        return response()->json([
            'message' => 'User Updated Successfully'
        ],200);
    }


    public function signupActivate($token){
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->email_verified_at = Carbon::now();
        $user->activation_token = '';
        $user->save();
        return view('verification.index');
    }

}
