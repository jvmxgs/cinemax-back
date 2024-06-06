<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    /**
     * Login user and return the token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponseWithData('Login successfully', [
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }
    }
}
