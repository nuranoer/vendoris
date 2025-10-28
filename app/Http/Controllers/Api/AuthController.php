<?php

// app/Http/Controllers/Api/AuthController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
  public function register(Request $r){
    $data = $r->validate([
      'name'=>'required|string|max:100',
      'email'=>'required|email|unique:users,email',
      'password'=>'required|min:6'
    ]);
    $data['password'] = Hash::make($data['password']);
    $u = User::create($data);
    return response()->json(['status'=>true,'message'=>'registered','data'=>['id'=>$u->id]]);
  }

  public function login(Request $r){
    $cred = $r->validate(['email'=>'required|email','password'=>'required']);
    if(!$token = auth('api')->attempt($cred)){
      return response()->json(['status'=>false,'message'=>'invalid credentials'],401);
    }
    return $this->respondWithToken($token);
  }

  public function me(){
    return response()->json(['status'=>true,'data'=>auth('api')->user()]);
  }

  public function refresh(){
    return $this->respondWithToken(auth('api')->refresh());
  }

  public function logout(){
    auth('api')->logout();
    return response()->json(['status'=>true,'message'=>'logged out']);
  }

  protected function respondWithToken($token){
    return response()->json([
      'status'=>true,
      'token'=>$token,
      'token_type'=>'bearer',
      'expires_in'=>auth('api')->factory()->getTTL() * 60
    ]);
  }
}

