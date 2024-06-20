<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Utils\CoreUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $CoreUtil;
    public function __construct(CoreUtil $CoreUtil)
    {
        $this->CoreUtil = $CoreUtil;
    }

    // Auth User
    public function login(AuthRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('auth-token')->plainTextToken;
                $result = [
                    'user' => $user,
                    'token' => $token,
                ];
                return $this->CoreUtil->sendResponse(true, $result, 'Login successful', null);
            }
            return $this->CoreUtil->sendResponse(false, null, 'Invalid email or password', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->CoreUtil->sendResponse(false, null, 'Login Failed', null);
        }
    }

    // Check User is authenticated
    public function checkAuth(Request $request)
    {
        if ($request->user()) {
            if ($request->user()->tokenCan('sanctum')) {
                return $this->CoreUtil->sendResponse(true, null, 'User is authenticated and token is valid.', null);
            } else {
                return $this->CoreUtil->sendResponse(false, null, 'Token is invalid or does not have necessary permissions.', null);
            }
        } else {
            return $this->CoreUtil->sendResponse(false, null, 'User is not authenticated.', null);
        }
    }

    // Log out
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
            return $this->CoreUtil->sendResponse(true, null, 'Logged out successfully', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->CoreUtil->sendResponse(false, null, 'Log Out Failed', null);
        }
    }
}
