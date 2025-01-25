<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;

class AuthController extends Controller
{
    use HttpResponses;
    //
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('','Invalid credentials',401);
        }
        $user = User::where('email',$request->email)->first();
        return $this->success(
            [
                'user' => $user,
                'token' => $user->createtoken('Access Token for' . $user->name)->plainTextToken
            ]);
    }
    public function register(StoreUserRequest $request){
        $request->validated(($request->all()));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
                'user' => $user,
                'token' => $user->createToken('Access Token of ' . $user->name)->plainTextToken
        ]);
        
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'the access token has been deleted successfully'
        ]);
    }

}
