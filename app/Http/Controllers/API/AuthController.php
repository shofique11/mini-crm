<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Illuminate\Support\Facades\App;
//use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AuthenticatedSessionController;
class AuthController extends BaseController
{
    // User Registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,counselor',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);
        App::make(EnableTwoFactorAuthentication::class)($user);
        $success['user'] = $user;
        return $this->sendResponse($success, 'User register successfully.', 201);
    }

    // User Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $controller = new AuthenticatedSessionController();
        return $controller->store($request);
    }

    // Get Authenticated User
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    // Logout User
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // Refresh JWT Token
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => JWTAuth::user(),
        ]);
    }
}
