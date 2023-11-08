<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\StoreUpdateUser;
use App\Http\Resources\Api\UserResource;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        // Logout others devices
        // if ($request->has('logout_others_devices'))
        $user->tokens()->delete();

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'me' => $user,
        ]);
    }

    public function register(StoreUpdateUser $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = $this->model->create($data);

        return new UserResource($user);
    }
}