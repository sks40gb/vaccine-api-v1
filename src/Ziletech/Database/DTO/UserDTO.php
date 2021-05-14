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
    public $ifscCode;
    public $accountNo;
    public $branchName;
    public $bankName;
    public $panNumber;
    public $address;

    /**
     *
     * @var UserBalanceDTO
     */
    public $balance;

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
     * @var boolean
     */
    public $pStatus;

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
     *
     * @var UserDTO 
     */
    public $owner;

    /**
     * UserDTO[]
     */
    public $referralList;

    /**
     * @var PlanDTO
     */
    public $plan;

    /**
     * @var RoleDTO
     */
    public $role;

    /**
     *
     * @var DepositDTO[]
     */
    public $depositList;

    /**
     *
     * @var PaymentLogDTO[]
     */
    public $paymentLogList;

    /**
     *
     * @var SupportDTO[]
     */
    public $SupportList;

    /**
     *
     * @var TransactionDTO[]
     */
    public $transactionList;

    /**
     *
     * @var UserLoginDTO[]
     */
    public $userLoginsList;

    /**
     *
     * @var WithdrawLogDTO[]
     */
    public $withdrawLogsList;
    //only for front end 
    public $planName;

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
        $this->panNumber = $user->panNumber;
        $this->bankName = $user->bankName;
        $this->branchName = $user->branchName;
        $this->accountNo = $user->accountNo;
        $this->ifscCode = $user->ifscCode;
        $this->address = $user->address;
        $this->referralId = $user->referralId;
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
        $user->pStatus = $this->pStatus;
        $user->loginTime = $this->loginTime;
        $user->createdAt = $this->createdAt;
        $user->panNumber = $this->panNumber;
        $user->bankName = $this->bankName;
        $user->branchName = $this->branchName;
        $user->accountNo = $this->accountNo;
        $user->ifscCode = $this->ifscCode;
        $user->address = $this->address;
    }

    function getId() {
        return $this->id;
    }

    function getReferralId() {
        return $this->referralId;
    }

    function setReferralId($referralId) {
        $this->referralId = $referralId;
    }

    function getName() {
        return $this->name;
    }

    function getUserName() {
        return $this->userName;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
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

    function getPassword() {
        return $this->password;
    }

    function getInactive() {
        return $this->inactive;
    }

    function getBalance(): UserBalanceDTO {
        return $this->balance;
    }

    function getProfilePic(): FileDTO {
        return $this->profilePic;
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

    function getResetPasswordToken() {
        return $this->resetPasswordToken;
    }

    function getPStatus() {
        return $this->pStatus;
    }

    function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    function getLoginTime(): DateTime {
        return $this->loginTime;
    }

    function getPlan(): ?PlanDTO {
        return $this->plan;
    }

    function getRole(): RoleDTO {
        return $this->role;
    }

    function getDepositList(): array {
        return $this->depositList;
    }

    function getPaymentLogList(): array {
        return $this->paymentLogList;
    }

    function getSupportList(): array {
        return $this->SupportList;
    }

    function getTransactionList(): array {
        return $this->transactionList;
    }

    function getUserLoginsList(): array {
        return $this->userLoginsList;
    }

    function getWithdrawLogsList(): array {
        return $this->withdrawLogsList;
    }

    function getPlanName() {
        return $this->planName;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
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

    function setPassword($password) {
        $this->password = $password;
    }

    function setInactive($inactive) {
        $this->inactive = $inactive;
    }

    function setBalance(?UserBalanceDTO $balance) {
        $this->balance = $balance;
    }

    function setProfilePic(?FileDTO $profilePic) {
        $this->profilePic = $profilePic;
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

    function setResetPasswordToken($resetPasswordToken) {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    function setPStatus($pStatus) {
        $this->pStatus = $pStatus;
    }

    function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(DateTime $updatedAt = null) {
        $this->updatedAt = $updatedAt;
    }

    function setLoginTime(DateTime $loginTime = null) {
        $this->loginTime = $loginTime;
    }

    function setPlan(PlanDTO $plan = null) {
        $this->plan = $plan;
    }

    function setRole(RoleDTO $role) {
        $this->role = $role;
    }

    function setDepositList(array $depositList = null) {
        $this->depositList = $depositList;
    }

    function setPaymentLogList(array $paymentLogList = null) {
        $this->paymentLogList = $paymentLogList;
    }

    function setSupportList(array $SupportList = null) {
        $this->SupportList = $SupportList;
    }

    function setTransactionList(array $transactionList = null) {
        $this->transactionList = $transactionList;
    }

    function setUserLoginsList(array $userLoginsList = null) {
        $this->userLoginsList = $userLoginsList;
    }

    function setWithdrawLogsList(array $withdrawLogsList = null) {
        $this->withdrawLogsList = $withdrawLogsList;
    }

    function setPlanName($planName) {
        $this->planName = $planName;
    }

    function getReferralList() {
        return $this->referralList;
    }

    function setReferralList($referralList) {
        $this->referralList = $referralList;
    }

    function getOwner(): ?UserDTO {
        return $this->owner;
    }

    function setOwner(?UserDTO $owner) {
        $this->owner = $owner;
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

}
