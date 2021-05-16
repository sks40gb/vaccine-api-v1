<?php

namespace Ziletech\Services\Notification;

use Ziletech\Database\DTO\UserDTO;
use Ziletech\Database\Entity\User;

interface NotificationService {

    public function sendResetPasswordEmail(string $email, string $token, UserDTO $userDTO);
}
