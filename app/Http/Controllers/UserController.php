<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessProdcast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    //roles in request validation : done 
    //resource containdata :done
    //middle ware :done

    //for the creating job task

    public function updateUserStatus()
    {
       // ProcessProdcast::dispatch();
        ProcessProdcast::dispatch()->delay(now()->addSeconds(15));

        // return response()->json([
        //     'message' => 'Job dispatched to update users with status = 0.'
        // ]);
        return response()->json(['message' => 'Broadcast job will start after 15 seconds']);

    }

 // 1. Get all users
 public function getAllUsers()
 {
     Log::info('getAllUsers method called');
     return UserResource::collection(User::all());
 }
    
    // 2. Get user by ID with all details
    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);

    }

    // 3. Add user with validation in the request

    public function addUser(UserRequest $request)
    {
        Log::info('addUser method called', ['request' => $request->all()]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user)
        ], 201);
    }
    // 4. Delete user by ID
    public function deleteUser($id)
    {
        $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $deletedUser = new UserResource($user);
    $user->delete();

    return response()->json([
        'message' => 'User deleted successfully',
        'user' => $deletedUser,
    ], 200);
    }

    // 5. Update user (name, email, or password)use App\Http\Requests\UpdateUserRequest;
    public function updateUser(UserRequest $request, $id)
{
    Log::info('updateUser method called', ['request' => $request->all(), 'id' => $id]);

    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->update([
        'name' => $request->name ?? $user->name,
        'email' => $request->email ?? $user->email,
        'password' => $request->has('password') ? Hash::make($request->password) : $user->password,
    ]);

    return response()->json([
        'message' => 'User updated successfully',
        'user' => new UserResource($user)
    ], 200);
    
}
//6.
public function getUserIdsByStatus($status)
{
    Log::info('getUserIdsByStatus method called', ['status' => $status]);
    
    // Fetch only the IDs of users where status matches the provided value
    $userIds = User::where('status', $status)->pluck('id');
    
    // Return the IDs as a JSON response
    return response()->json([
        'user_ids' => $userIds
    ]);
}
}