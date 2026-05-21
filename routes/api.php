<?php

use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ], 401);
    }

    $user->tokens()->where('name', 'api-token')->delete();
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful.',
        'token'   => $token,
        'user'    => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ],
    ]);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'user',
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'token'   => $token,
        'user'    => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
    ], 201);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $r) => response()->json(['user' => $r->user()]));

    Route::post('/logout', function (Request $r) {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out.']);
    });

    Route::get('/tasks',                   [TaskApiController::class, 'index']);
    Route::post('/tasks',                  [TaskApiController::class, 'store']);
    Route::get('/tasks/{task}',            [TaskApiController::class, 'show']);
    Route::put('/tasks/{task}',            [TaskApiController::class, 'update']);
    Route::delete('/tasks/{task}',         [TaskApiController::class, 'destroy']);
    Route::patch('/tasks/{task}/complete', [TaskApiController::class, 'complete']);
});
