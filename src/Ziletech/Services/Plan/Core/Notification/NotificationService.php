<?php

namespace Ziletech\Services\Plan\Core\Notification;

use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\User;

interface NotificationService {

    public function notifyDirectReferral(UserDTO $userDTO, string $description);

    public function notifyDeposit(UserDTO $userDTO, string $description);

    public function notifyWithdraw(UserDTO $userDTO, string $description);

    public function notifyWithdrawCharge(UserDTO $userDTO, string $description);

    public function notifyUserActive(UserDTO $userDTO);

    public function sendInvoice(string $email, $userId);

    public function notifyRegister(string $password, UserDTO $userDTO);

    public function sendResetPasswordEmail(string $email, string $token, UserDTO $userDTO);
}
