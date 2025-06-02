<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json(['data'=>$user]); //api biasa
        // return UserResource::collection(($user)); //api resource
    }

    public function store(Request $request) {
        $validatedData = $this->validateUser($request);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        return response()->json($user, 201);
    }

    public function show($id){
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'babay user']);
    }

    private function validateUser(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => ['required', Rule::in(['admin,penjual,konsumen'])],
        ]);
        
    }
}
