<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'meta' => [
                    'message' => 'All user ada yuhuu'
                ],
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'wuuu',
                    'error' => $e->getMessage()
                ]
            ]); 
        }
    }

    public function store(Request $request) {
        try {
            
        $validatedData = $this->validateUser($request);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        return response()->json([
                'meta' => [
                    'message' => 'User nambah yeay'
                ],
                'data' => $user
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'meta' => [
                    'message' => 'GAGALL KOCAK',
                    'errors' => $e->errors()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'keknya ada yang salah',
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    public function show($id){
       try {
        $user = User::findOrFail($id);
            return response()->json([
                'meta' => [
                    'message' => 'User ada yuhuu'
                ],
                'data' => $user
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'meta' => [
                    'message' => 'gada usernya tuh'
                ]
            ]);
       }
    }

    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $abc = $user->this_does_not_exist;
            $user->delete();
            
            return response()->json([
                'meta' => [
                    'message' => 'babay user'
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'meta' => [
                    'message' => 'User gada'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'yahaha failed',
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    private function validateUser(Request $request)
    {
        return $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => ['required',Rule::in(['admin', 'penjual', 'konsumen'])],
        ]);
        
    }
}

// return UserResource::collection(($user)); //api resource