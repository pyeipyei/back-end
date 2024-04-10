<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $registerData): string
    {
        return $this->authRepository->register($registerData);
    }

    public function verifyEmail(array $verifyData): string
    {
        return $this->authRepository->verifyEmail($verifyData);
    }

    public function login(array $loginData): array
    {
        return $this->authRepository->login($loginData);
    }

    public function resetPassword(string $email): string
    {
        return $this->authRepository->resetPassword($email);
    }

    public function checkConfirmationCode(string $email, string $code): string
    {
        return $this->authRepository->checkConfirmationCode($email, $code);
    }

    public function resetPasswordUsingEmail(string $email, string $password): string
    {
        return $this->authRepository->resetPasswordUsingEmail($email, $password);
    }

    public function updatePassword(string $email, string $oldPassword, $newPassword): string
    {
        return $this->authRepository->updatePassword($email, $oldPassword, $newPassword);
    }

    public function logout($email): string
    {
        return $this->authRepository->logout($email);
    }
}