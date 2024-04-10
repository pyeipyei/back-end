<?php

namespace App\Http\Controllers\Auth;

use App\Events\AuthEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\AuthResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    public function register(RegisterRequest $request)
    {
        try {
            $registerData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'employee_id' => $request->input('employee_id'),
                'password' => $request->input('password'),
                'confirmPassword' => $request->input('confirmPassword'),
            ];
            $result = $this->authService->register($registerData);
            if ($result == 'success') {
                $auth[0] = 'Created';
                $auth[1] = 'Registered New User ' . $registerData['name'] . ' in Signup screen';
                $auth[2] = $registerData['name'];
                event(new AuthEvent($auth));
                $response = [
                    "status" => true,
                    "message" => "Success"
                ];
            } else {
                $response = [
                    "status" => false,
                    "message" => "User already exists"
                ];
            }
            return new AuthResource($response);
        } catch (\Exception $e) {
            error_log($e);
            return Response::error('An error occurred', 500);
        }
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        } else {
            $verifyData = [
                'email' => $request->input('email'),
                'confirmation_code' => $request->input('code')
            ];
            $result = $this->authService->verifyEmail($verifyData);
            return new AuthResource($result);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $loginData = [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ];
                $result = $this->authService->login($loginData);
                if ($result['token'] == null) {
                    return new AuthResource($result);
                } else {
                    $auth[0] = 'Login';
                    $auth[1] = 'User Login Email(' . $loginData['email'] . ') in SignIn screen';
                    $auth[2] = $result['user']->name;
                    event(new AuthEvent($auth));
                    return new AuthResource($result);
                }
            }
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $email = $request->input('email');
                $result = $this->authService->resetPassword($email);
                if ($result == "true") {
                    $response = [
                        "mailSent" => true,
                        "message" => "The confirmation code has been sent to your email."
                    ];
                } else {
                    $response = [
                        "mailSent" => false,
                        "message" => "User does not exist"
                    ];
                }
                return new AuthResource($response);
            }
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function checkConfirmationCode(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'code' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $email = $request->input('email');
                $code = $request->input('code');
                $result = $this->authService->checkConfirmationCode($email, $code);
                if ($result == "true") {
                    $response = [
                        "codeMatched" => true,
                        "message" => "The confirmation code matched."
                    ];
                } else {
                    $response = [
                        "codeMatched" => false,
                        "message" => "The confirmation code does not match."
                    ];
                }
                return new AuthResource($response);
            }
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function resetPasswordUsingEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'confirmPassword' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $email = $request->input('email');
                $password = $request->input('password');
                $result = $this->authService->resetPasswordUsingEmail($email, $password);
                if ($result == "true") {
                    $response = [
                        "passwordUpdated" => true,
                        "message" => "The password has been reset."
                    ];
                } else {
                    $response = [
                        "passwordUpdated" => false,
                        "message" => "The password has not been reset."
                    ];
                }
                return new AuthResource($response);
            }
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'oldPassword' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required|same:newPassword',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            } else {
                $email = $request->input('email');
                $oldPassword = $request->input('oldPassword');
                $newPassword = $request->input('newPassword');
                $result = $this->authService->updatePassword($email, $oldPassword, $newPassword);
                if ($result == "true") {
                    $response = [
                        "passwordUpdated" => true,
                        "message" => "The password has been updated."
                    ];
                } else {
                    $response = [
                        "passwordUpdated" => false,
                        "message" => "The password has not been updated."
                    ];
                }
                return new AuthResource($response);
            }
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $email = $request->input('email');
            $result = $this->authService->logout($email);
            if ($result == "true") {
                $response = [
                    "logout" => true,
                    "message" => "The user has been logged out."
                ];
            } else {
                $response = [
                    "logout" => false,
                    "message" => "The user has not been logged out."
                ];
            }
            return new AuthResource($response);
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }
}
