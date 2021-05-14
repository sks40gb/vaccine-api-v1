<?php

namespace Ziletech\Database\Entity;

/**
 * @Entity @Table(name="user")
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

    /** @Column(type="datetime", name="updated_at") * */
    protected $updatedAt;

    /** @Column(type="string", name="ev_code") * */
    protected $emailVerifyCode;

    /** @Column(type="datetime", name="ev_time") * */
    protected $emailVerifyTime;

    /** @Column(type="string", name="pv_code") * */
    protected $phoneVerifyCode;

    /** @Column(type="datetime", name="pv_time") * */
    protected $phoneVerifyTime;

    /** @Column(type="integer", name="email_verify") * */
    protected $emailVerify;

    /** @Column(type="integer", name="phone_verify") * */
    protected $phoneVerify;

    /** @Column(type="integer", name="status") * */
    protected $status;

    /** @Column(type="string", name="remember_token") * */
    protected $rememberToken;

    /** @Column(type="string", name="reset_password_token") * */
    protected $resetPasswordToken;

    /** @Column(type="string", name="referral_id") * */
    protected $referralId;

    /** @Column(type="string", name="ifsc_code") * */
    protected $ifscCode;

    /** @Column(type="string", name="account_no") * */
    protected $accountNo;

    /** @Column(type="string", name="branch_name") * */
    protected $branchName;

    /** @Column(type="string", name="bank_name") * */
    protected $bankName;

    /** @Column(type="string", name="pan_number") * */
    protected $panNumber;

    /** @Column(type="string", name="address") * */
    protected $address;

    /** @Column(type="integer", name="p_status") * */
    protected $pStatus;

    /** @Column(type="datetime", name="login_time") * */
    protected $loginTime;

    /**
     * @ManyToOne(targetEntity="File")
     * @JoinColumn(name="profile_pic", referencedColumnName="id")
     */
    protected $profilePic;

    /**
     * @OneToMany(targetEntity="Deposit", mappedBy="user" , orphanRemoval=true)
     */
    protected $depositList;

    /**
     * @OneToMany(targetEntity="PaymentLog", mappedBy="member" , orphanRemoval=true)
     */
    protected $paymentLogList;

    /**
     * @OneToMany(targetEntity="Support", mappedBy="user" , orphanRemoval=true)
     */
    protected $supportList;

    /**
     * @OneToMany(targetEntity="Transaction", mappedBy="user" , orphanRemoval=true)
     */
    protected $transactionList;

    /**
     * @OneToMany(targetEntity="UserLogin", mappedBy="user" , orphanRemoval=true)
     */
    protected $userLoginsList;

    /**
     * @OneToMany(targetEntity="Withdraw", mappedBy="user" , orphanRemoval=true)
     */
    protected $withdrawLogsList;

    /**
     * @OneToOne(targetEntity="Plan")
     * @JoinColumn(name="plan_id", referencedColumnName="id")
     */
    private $plan;

    /**
     * @OneToMany(targetEntity="SupportMessage", mappedBy="user" , orphanRemoval=true)
     */
    protected $supportMessagesList;

    /**
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $role;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @OneToMany(targetEntity="User", mappedBy="owner")
     */
    protected $referralList;

    /**
     * @OneToOne(targetEntity="UserBalance", mappedBy="user", orphanRemoval=true)
     */
    protected $balance;

    function __construct() {
        $this->emailVerify = 0;
        $this->phoneVerify = 0;
        $this->status = 0;
        $this->pStatus = false;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getUserName() {
        return $this->userName;
    }

    function getPassword() {
        return $this->password;
    }

    function getPhone() {
        return $this->phone;
    }

    function getEmail() {
        return $this->email;
    }

    function getDob() {
        return $this->dob;
    }

    function getGender() {
        return $this->gender;
    }

    function getCountry() {
        return $this->country;
    }

    function getImage() {
        return $this->image;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getEmailVerifyCode() {
        return $this->emailVerifyCode;
    }

    function getEmailVerifyTime() {
        return $this->emailVerifyTime;
    }

    function getPhoneVerifyCode() {
        return $this->phoneVerifyCode;
    }

    function getPhoneVerifyTime() {
        return $this->phoneVerifyTime;
    }

    function getEmailVerify() {
        return $this->emailVerify;
    }

    function getPhoneVerify() {
        return $this->phoneVerify;
    }

    function getStatus() {
        return $this->status;
    }

    function getRememberToken() {
        return $this->rememberToken;
    }

    function getPStatus() {
        return $this->pStatus;
    }

    function getLoginTime() {
        return $this->loginTime;
    }

    function getDepositList() {
        return $this->depositList;
    }

    function getPaymentLogList() {
        return $this->paymentLogList;
    }

    function getSupportList() {
        return $this->supportList;
    }

    function getUserLoginsList() {
        return $this->userLoginsList;
    }

    function getWithdrawLogsList() {
        return $this->withdrawLogsList;
    }

    function getPlan() {
        return $this->plan;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setCountry($country) {
        $this->country = $country;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setEmailVerifyCode($emailVerifyCode) {
        $this->emailVerifyCode = $emailVerifyCode;
    }

    function setEmailVerifyTime($emailVerifyTime) {
        $this->emailVerifyTime = $emailVerifyTime;
    }

    function setPhoneVerifyCode($phoneVerifyCode) {
        $this->phoneVerifyCode = $phoneVerifyCode;
    }

    function setPhoneVerifyTime($phoneVerifyTime) {
        $this->phoneVerifyTime = $phoneVerifyTime;
    }

    function setEmailVerify($emailVerify) {
        $this->emailVerify = $emailVerify;
    }

    function setPhoneVerify($phoneVerify) {
        $this->phoneVerify = $phoneVerify;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setRememberToken($rememberToken) {
        $this->rememberToken = $rememberToken;
    }

    function setPStatus($pStatus) {
        $this->pStatus = $pStatus;
    }

    function setLoginTime($loginTime) {
        $this->loginTime = $loginTime;
    }

    function setDepositList($depositList) {
        $this->depositList = $depositList;
    }

    function setPaymentLogList($paymentLogList) {
        $this->paymentLogList = $paymentLogList;
    }

    function setSupportList($supportList) {
        $this->supportList = $supportList;
    }

    function setUserLoginsList($userLoginsList) {
        $this->userLoginsList = $userLoginsList;
    }

    function setWithdrawLogsList($withdrawLogsList) {
        $this->withdrawLogsList = $withdrawLogsList;
    }

    function setPlan($plan) {
        $this->plan = $plan;
    }

    function getProfilePic() {
        return $this->profilePic;
    }

    function setProfilePic($profilePic) {
        $this->profilePic = $profilePic;
    }

    function getSupportMessagesList() {
        return $this->supportMessagesList;
    }

    function setSupportMessagesList($supportMessagesList) {
        $this->supportMessagesList = $supportMessagesList;
    }

    function getTransactionList() {
        return $this->transactionList;
    }

    function setTransactionList($transactionList) {
        $this->transactionList = $transactionList;
    }

    function getRole() {
        return $this->role;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function getBalance(): ?UserBalance {
        return $this->balance;
    }

    function setBalance(?UserBalance $balance) {
        $this->balance = $balance;
    }

    function getResetPasswordToken() {
        return $this->resetPasswordToken;
    }

    function setResetPasswordToken($resetPasswordToken) {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    function getSponsor() {
        return $this->sponsor;
    }

    function getReferralList() {
        return $this->referralList;
    }

    function getOwner() {
        return $this->owner;
    }

    function setOwner($owner) {
        $this->owner = $owner;
    }

    function getReferralId() {
        return $this->referralId;
    }

    function setReferralId($referralId) {
        $this->referralId = $referralId;
    }

    function getActivationDate() {
        return $this->activationDate;
    }

    function setActivationDate($activationDate) {
        $this->activationDate = $activationDate;
    }

    function getIfscCode() {
        return $this->ifscCode;
    }

    function getAccountNo() {
        return $this->accountNo;
    }

    function getBranchName() {
        return $this->branchName;
    }

    function getBankName() {
        return $this->bankName;
    }

    function getPanNumber() {
        return $this->panNumber;
    }

    function setIfscCode($ifscCode) {
        $this->ifscCode = $ifscCode;
    }

    function setAccountNo($accountNo) {
        $this->accountNo = $accountNo;
    }

    function setBranchName($branchName) {
        $this->branchName = $branchName;
    }

    function setBankName($bankName) {
        $this->bankName = $bankName;
    }

    function setPanNumber($panNumber) {
        $this->panNumber = $panNumber;
    }

    function getAddress() {
        return $this->address;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    public function __toString() {
        return "User[id: $this->id]";
    }

}
