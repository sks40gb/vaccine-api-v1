<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity
 * @Table(name="user")
 * */
class User extends BaseEntity {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", name="name") * */
    protected $name;

    /** @Column(type="string", name="username") * */
    protected $userName;

    /** @Column(type="string", name="password") * */
    protected $password;

    /** @Column(type="string", name="phone") * */
    protected $phone;

    /** @Column(type="string", name="email") * */
    protected $email;

    /** @Column(type="string", name="dob") * */
    protected $dob;

    /** @Column(type="string", name="gender") * */
    protected $gender;

    /** @Column(type="string", name="country") * */
    protected $country;

    /** @Column(type="string", name="image") * */
    protected $image;

    /** @Column(type="datetime", name="created_at") * */
    protected $createdAt;

    /** @Column(type="datetime", name="activation_date") * */
    protected $activationDate;

    /** @Column(type="datetime", name="login_time") * */
    protected $loginTime;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="string", name="remember_token") * */
    protected $rememberToken;

    /** @Column(type="string", name="reset_password_token") * */
    protected $resetPasswordToken;

    /**
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $role;

    /** @Column(type="string", name="address") * */
    protected $address;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="profile_pic", referencedColumnName="id")
     */
    protected $profilePic;

    function __construct() {
        $this->status = 0;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
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
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getLoginTime() {
        return $this->loginTime;
    }

    /**
     * @param mixed $loginTime
     */
    public function setLoginTime($loginTime): void {
        $this->loginTime = $loginTime;
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
     * @return mixed
     */
    public function getRememberToken() {
        return $this->rememberToken;
    }

    /**
     * @param mixed $rememberToken
     */
    public function setRememberToken($rememberToken): void {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return mixed
     */
    public function getResetPasswordToken() {
        return $this->resetPasswordToken;
    }

    /**
     * @param mixed $resetPasswordToken
     */
    public function setResetPasswordToken($resetPasswordToken): void {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    /**
     * @return mixed
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getProfilePic() {
        return $this->profilePic;
    }

    /**
     * @param mixed $profilePic
     */
    public function setProfilePic($profilePic): void {
        $this->profilePic = $profilePic;
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
     * @return mixed
     */
    public function getActivationDate() {
        return $this->activationDate;
    }

    /**
     * @param mixed $activationDate
     */
    public function setActivationDate($activationDate): void {
        $this->activationDate = $activationDate;
    }

    public function __toString() {
        return "User[id: $this->id]";
    }

}
