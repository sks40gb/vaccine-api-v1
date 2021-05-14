<?php

namespace Ziletech\Models;

use DateTime;
use Ziletech\Database\Entity\User;

class UserModel {

    /**
     * @var integer
     */
    public $id;
    public $userName;
    public $name;
    public $email;
    public $gender;
    public $role;
    public $profilePic;
    public $token;
    public $referralLink;
    public $status;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $activationDate;
    
    public function __construct(User $user = null) {
        if (isset($user)) {
            $this->copyFromDomain($user);
        }
    }

    public function copyFromDomain($user) {
        $this->id = $user->id;
        $this->userName = $user->userName;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->gender = $user->gender;
        $this->token = $user->token;
        $this->createdAt = $user->createdAt;
        $this->activationDate = $user->activationDate;
        $this->status = $user->status;
        
        if ($user->getProfilePic() != null) {
            $this->profilePic = $user->getProfilePic()->getId();
        }
        if ($user->getRole() != null) {
            $this->role = $user->getRole()->getName();
        }
    }

    function getId() {
        return $this->id;
    }

    function getUserName() {
        return $this->userName;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getGender() {
        return $this->gender;
    }

    function getRole() {
        return $this->role;
    }

    function getProfilePic() {
        return $this->profilePic;
    }

    function getToken() {
        return $this->token;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setProfilePic($profilePic) {
        $this->profilePic = $profilePic;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function getReferralLink() {
        return $this->referralLink;
    }

    function setReferralLink($referralLink) {
        $this->referralLink = $referralLink;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getActivationDate(): DateTime {
        return $this->activationDate;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setActivationDate(DateTime $activationDate) {
        $this->activationDate = $activationDate;
    }
    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

}
