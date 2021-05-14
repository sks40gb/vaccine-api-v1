<?php

namespace Ziletech\Services\Auth;

use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Slim\Collection;
use Slim\Http\Request;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\User;

class Auth {

    const SUBJECT_IDENTIFIER = 'userName';

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /**
     * @var array
     */
    private $appConfig;

    /**
     * Auth constructor.
     *
     * @param DAOFactory $daoFactory
     * @param array|Collection               $appConfig
     */
    public function __construct(DAOFactory $daoFactory, Collection $appConfig) {
        $this->daoFactory = $daoFactory;
        $this->appConfig = $appConfig;
    }

    /**
     * Generate a new JWT token
     *
     * @param \Ziletech\Models\User $user
     *
     * @return string
     * @internal param string $subjectIdentifier The username of the subject user.
     *
     */
    public function generateToken(User $user) {
        $now = new DateTime();
        $future = new DateTime("now +2 hours");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            'iss' => $this->appConfig['app']['url'], // Issuer
            "sub" => $user->{Self::SUBJECT_IDENTIFIER},
//            "role" => $user->getRole()->getName()
        ];

        $secret = $this->appConfig['jwt']['secret'];
        $token = JWT::encode($payload, $secret, "HS256");

        return $token;
    }

    /**
     * Attempt to find the user based on email and verify password
     *
     * @param $email
     * @param $password
     *
     * @return bool|\Ziletech\Models\User
     */
    public function attempt($userName, $password) {
        if (!$user = $this->daoFactory->getUserDAO()->getByUserName($userName)) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            return $user;
        }

        return false;
    }

    /**
     * Retrieve a user by the JWT token from the request
     *
     * @param Request $request
     *
     * @return User|null
     */
    public function requestUser(Request $request) {
        // Should add more validation to the present and validity of the token?
        if ($token = $request->getAttribute('token')) {
            return $this->daoFactory->getUserDAO()->getByProperty(static::SUBJECT_IDENTIFIER, $token->sub);
        }
    }

}
