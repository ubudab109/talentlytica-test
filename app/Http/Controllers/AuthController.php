<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * LOGIN REQUEST
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest('Validation Error', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return $this->sendUnauthorized('User Not Found', 'User not found');
        }
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('user_token')->plainTextToken;
            return $this->sendResponse([
                'token' => $token,
                'user' => $user,
            ], 'Successfully Login');
        } else {
            return $this->sendUnauthorized('Failed', 'Wrong Password');
        }
    }

    /**
     * Logout Process
     * 
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse(null, 'Successfully Logout');
    }
}
