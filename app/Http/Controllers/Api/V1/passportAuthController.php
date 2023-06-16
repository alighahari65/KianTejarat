<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Validator;

class passportAuthController extends Controller
{
    use ApiResponse;

    /**
     * handle user registration request
     */

    public function registerUser(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile_number' => 'required|digits:11',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $token = $user->createToken('AliGhahari')->accessToken;

            return $this->successResponse([
                'user' => new UserResource($user),
                'token' => $token,
            ], __('messages.User Successfully Created'), 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * login user to our application
     */
    public function loginUser(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'mobile_number' => 'required|digits:11',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            $login_credentials = [
                'mobile_number' => $request->mobile_number,
                'password' => $request->password,
            ];

            if (auth()->attempt($login_credentials)) {
                //generate the token for the user
                $user_login_token = auth()->user()->createToken('AliGhahari')->accessToken;

                return $this->successResponse([
                    'is_verify' => true,
                    'access_token' => $user_login_token,
                ], __('messages.User Successfully Loged In'));
            } else {
                return $this->errorResponse(__('messages.Unauthorized'), 401);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails()
    {
        //returns details
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
