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
                    'status_code' => 200,
                    'success' => true,
                    'message' => 'All user ada yuhuu'
                ],
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'status_code' => 500,
                    'success' => false,
                    'message' => 'wuuu',
                    'error' => $e->getMessage()
                ]
            ],500); 
        }
    }

    public function store(Request $request) {
        try {
            
        $validatedData = $this->validateUser($request);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        return response()->json([
                'meta' => [
                    'status_code' => 201,
                    'success' => true,
                    'message' => 'User nambah yeay'
                ],
                'data' => $user
            ],201);

        } catch (ValidationException $e) {
            return response()->json([
                'meta' => [
                    'status_code' => 422,
                    'success' => false,
                    'message' => 'GAGALL KOCAK',
                    'errors' => $e->errors()
                ]
            ],422);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'status_code' => 500,
                    'success' => false,
                    'message' => 'keknya ada yang salah',
                    'error' => $e->getMessage()
                ]
            ],500);
        }
    }

    public function show($id){
       try {
        $user = User::findOrFail($id);
            return response()->json([
                'meta' => [
                     'status_code' => 200,
                    'success' => true,
                    'message' => 'User ada yuhuu'
                ],
                'data' => $user
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'meta' => [
                    'status_code' => 404,
                    'success' => false,
                    'message' => 'gada usernya tuh'
                ]
            ],404);
       }
    }

    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $abc = $user->this_does_not_exist;
            $user->delete();
            
            return response()->json([
                'meta' => [
                    'status_code' => 200,
                    'success' => true,
                    'message' => 'babay user'
                ]
            ]);
        
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'status_code' => 500,
                    'success' => false,
                    'message' => 'yahaha failed',
                    'error' => $e->getMessage()
                ]
            ],500);
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