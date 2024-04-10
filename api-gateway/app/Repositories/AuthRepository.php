<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\VerifyMail;
use Mail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\RegistrationSuccessNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Events\Registered;
use App\Events\AuthEvent;

class AuthRepository
{
    public function register(array $registerData): string
    {
        DB::begintransaction();
        try {
            $result = collect(User::where('name', $registerData['name'])
                ->where('email', $registerData['email'])
                ->where('employee_id', $registerData['employee_id'])
                ->get());
            if (count($result) < 1) {
                $user = User::create([
                    'name' => $registerData['name'],
                    'email' => $registerData['email'],
                    'employee_id' => $registerData['employee_id'],
                    'password' => Hash::make($registerData['password']),
                ]);
                $message = "success";
            } else {
                $message = "exists";
            }
            if ($message == "success") {
               // send code to user email
               $code = random_int(100000, 999999);
                $user->update(['confirmation_code' => $code]);

                // Use the notify method to send the notification
                Notification::send($user, new RegistrationSuccessNotification($code));
            }
            DB::commit();
            return $message;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function verifyEmail(array $verifyData): string 
    {
        $user = User::where('email', $verifyData['email'])->first();

    // Check if the user exists and the confirmation code is correct
    if ($user && $verifyData['confirmation_code'] == $user->confirmation_code) {
        // Update the email_verified_at column
        $user->email_verified_at = now();
        $user->save();
        $auth[0] = 'Verify Email';
        $auth[1] = 'Verify Email Email(' . $verifyData['email'] . ') in Verify Email screen';
        $auth[2] = $user->name;
        event(new AuthEvent($auth));
        return 'verification_success';
    }

    return 'verification_fail';

    }

    public function login(array $loginData): array
    {
        DB::begintransaction();
        try{
            $user = User::where('email', $loginData['email'])
            ->orWhere('employee_id', $loginData['email'])
            ->first();
            error_log("user " . $user);
        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return [
                "token" => null,
                "message" => "Invalid Credentials"
            ];
        } else {
            if (is_null($user->email_verified_at)) {
                return [
                    "token" => null,
                    "message" => "Please verify your email first."
                ];
            } else {
                DB::commit();
            $token = $user->createToken('API TOKEN', expiresAt:now()->addHours(3))->plainTextToken;
            return [
                "token" => $token,
                "user" => $user,
                "message" => "Login Success"
            ];
            }
        }

        } catch(\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "validation error",
                "error" => $th->getMessage()
            ], 500);
        }
    }


    public function resetPassword(string $email): string
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $code = random_int(100000, 999999);
                $user->update(['confirmation_code' => $code]);

                // Use the notify method to send the notification
                Notification::send($user, new ResetPasswordNotification($code));
                $auth[0] = 'Reset Password';
                $auth[1] = 'Reset Password Email(' . $email . ') in Forgot Password screen';
                $auth[2] = $user->name;
                event(new AuthEvent($auth));
                DB::commit();
                return "true";
            } else {
                DB::commit();
                return "false";
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "An error occurred: " . $e->getMessage();
        }
    }

    public function checkConfirmationCode(string $email, string $code): string
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                if ($user->confirmation_code == $code) {
                    DB::commit();
                    $auth[0] = 'Verify Code';
                    $auth[1] = 'Verify Code Email(' . $email . ') in Verify Code screen';
                    $auth[2] = $user->name;
                    event(new AuthEvent($auth));
                    return "true";
                } else {
                    DB::commit();
                    return "false";
                }
            } else {
                DB::commit();
                return "Email does not exist.";
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "An error occurred: " . $e->getMessage();
        }
    }

    public function resetPasswordUsingEmail(string $email, string $newPassword): string
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->update(['password' => Hash::make($newPassword)]);
                DB::commit();
                $auth[0] = 'Reset Password';
                    $auth[1] = 'Reset Password Email(' . $email . ') in Forgot Password screen';
                    $auth[2] = $user->name;
                    event(new AuthEvent($auth));
                return "true";
            } else {
                DB::commit();
                return "false";
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "An error occurred: " . $e->getMessage();
        }
    }

    public function updatePassword(string $email, string $oldPassword, string $newPassword): string
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                if (Hash::check($oldPassword, $user->password)) {
                    $user->update(['password' => Hash::make($newPassword)]);
                    DB::commit();
                    $auth[0] = 'Change Password';
                    $auth[1] = 'Change Password Email(' . $email . ') in Change Password screen';
                    $auth[2] = $user->name;
                    event(new AuthEvent($auth));
                    return "true";
                } else {
                    DB::commit();
                    return "false";
                }
            } else {
                DB::commit();
                return "Email does not exist.";
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "An error occurred: " . $e->getMessage();
        }
    }

    
    public function logout(string $email): string
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->tokens()->delete();
                DB::commit();
                return "true";
            } else {
                DB::commit();
                return "false";
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "An error occurred: " . $e->getMessage();
        }
    }
    

}
