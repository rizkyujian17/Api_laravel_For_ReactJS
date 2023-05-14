<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
 

    //buat user
    public function createNewUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    public function tesTing(){
        return response()->json("teshasil");
    }
    //login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    //Update User
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $token = $user->tokens()->where('name', 'token-name')->first()->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }
    //delete User 
    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    //logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
