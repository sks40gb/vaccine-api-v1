<?php

namespace Ziletech\Database\DTO;

use DateTime;
use Ziletech\Database\Entity\User;

class UserDTO extends BaseDTO {

    /**
     * @var integer
     */
    public $id;
    public $name;
    public $userName;
    public $email;
    public $phone;
    public $dob;
    public $gender;
    public $country;
    public $image;
    public $password;
    public $inactive;
    public $address;

    /**
     *
     * @var FileDTO
     */
    public $profilePic;

    /**
     * @var integer
     */
    public $emailVerify;

    /**
     * @var integer
     */
    public $phoneVerify;

    /**
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $rememberToken;

    /**
     *
     * @var string
     */
    public $referralId;

    /**
     *
     * @var string
     */
    public $resetPasswordToken;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @var DateTime
     */
    public $loginTime;

    /**
     * @var RoleDTO
     */
    public $role;

    /**
     *
     * @var UserLoginDTO[]
     */

    public function __construct(User $user = null) {
        if (isset($user)) {
            $this->copyFromDomain($user);
        }
    }

    public function copyFromDomain(User $user) {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->userName = $user->userName;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->dob = $user->dob;
        $this->gender = $user->gender;
        $this->country = $user->country;
        $this->image = $user->image;
        $this->createdAt = $user->createdAt;
        $this->status = $user->status;
        $this->address = $user->address;
    }

    public function copyToDomain($user) {
        $user->id = $this->id;
        $user->name = $this->name;
        $user->userName = $this->userName;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->dob = $this->dob;
        $user->gender = $this->gender;
        $user->country = $this->country;
        $user->image = $this->image;
        $user->emailVerify = $this->emailVerify;
        $user->phoneVerify = $this->phoneVerify;
        $user->status = $this->status;
        $user->rememberToken = $this->rememberToken;
        $user->referralId = $this->referralId;
        $user->loginTime = $this->loginTime;
        $user->createdAt = $this->createdAt;
        $user->address = $this->address;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getDob() {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     */
    public function setDob($dob): void {
        $this->dob = $dob;
    }

    /**
     * @return mixed
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getInactive() {
        return $this->inactive;
    }

    /**
     * @param mixed $inactive
     */
    public function setInactive($inactive): void {
        $this->inactive = $inactive;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void {
        $this->address = $address;
    }

    /**
     * @return FileDTO
     */
    public function getProfilePic(): FileDTO {
        return $this->profilePic;
    }

    /**
     * @param FileDTO $profilePic
     */
    public function setProfilePic(FileDTO $profilePic): void {
        $this->profilePic = $profilePic;
    }

    /**
     * @return int
     */
    public function getEmailVerify(): int {
        return $this->emailVerify;
    }

    /**
     * @param int $emailVerify
     */
    public function setEmailVerify(int $emailVerify): void {
        $this->emailVerify = $emailVerify;
    }

    /**
     * @return int
     */
    public function getPhoneVerify(): int {
        return $this->phoneVerify;
    }

    /**
     * @param int $phoneVerify
     */
    public function setPhoneVerify(int $phoneVerify): void {
        $this->phoneVerify = $phoneVerify;
    }

    /**
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getRememberToken(): string {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     */
    public function setRememberToken(string $rememberToken): void {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return string
     */
    public function getReferralId(): string {
        return $this->referralId;
    }

    /**
     * @param string $referralId
     */
    public function setReferralId(string $referralId): void {
        $this->referralId = $referralId;
    }

    /**
     * @return string
     */
    public function getResetPasswordToken(): string {
        return $this->resetPasswordToken;
    }

    /**
     * @param string $resetPasswordToken
     */
    public function setResetPasswordToken(string $resetPasswordToken): void {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getLoginTime(): DateTime {
        return $this->loginTime;
    }

    /**
     * @param DateTime $loginTime
     */
    public function setLoginTime(DateTime $loginTime): void {
        $this->loginTime = $loginTime;
    }

    /**
     * @return RoleDTO
     */
    public function getRole(): RoleDTO {
        return $this->role;
    }

    /**
     * @param RoleDTO $role
     */
    public function setRole(RoleDTO $role): void {
        $this->role = $role;
    }


}
