<?php

namespace Ziletech\Database\DTO;

use Ziletech\Database\Entity\GenericCode;
use Ziletech\Database\Entity\UserBalance;

class DTOFactory {

    public static function getUserDTO($user = null): UserDTO {
        return new UserDTO($user);
    }

    public static function getUserTreeDTO($userTree = null): UserTreeDTO {
        return new UserTreeDTO($userTree);
    }

    public static function getPlanDTO($plan = null): PlanDTO {
        return new PlanDTO($plan);
    }

    public static function getMenuDTO($menu = null): MenuDTO {
        return new MenuDTO($menu);
    }

    public static function getTestimonialDTO($testimonial = null): TestimonialDTO {
        return new TestimonialDTO($testimonial);
    }

    public static function getWithdrawLogDTO($withdrawLog = null): WithdrawLogDTO {
        return new WithdrawLogDTO($withdrawLog);
    }

    public static function getSubscribeDTO($subscribe = null): SubscribeDTO {
        return new SubscribeDTO($subscribe);
    }

    public static function getSliderDTO($subscribe = null): SliderDTO {
        return new SliderDTO($subscribe);
    }

    public static function getBasicSettingDTO($basicSetting = null): BasicSettingDTO {
        return new BasicSettingDTO($basicSetting);
    }

    public static function getWithdrawMethodDTO($withdrawMethod = null): WithdrawMethodDTO {
        return new WithdrawMethodDTO($withdrawMethod);
    }

    public static function getTransactionDTO($transactionDTO = null): TransactionDTO {
        return new TransactionDTO($transactionDTO);
    }

    public static function getDepositDTO($depositDTO = null): DepositDTO {
        return new DepositDTO($depositDTO);
    }

    public static function getPaymentMethodDTO($paymentMethodDTO = null): PaymentMethodDTO {
        return new PaymentMethodDTO($paymentMethodDTO);
    }

    public static function getCalulateWithdrawFundRequestDTO() {
        return new CalulateWithdrawFundRequestDTO();
    }

    public static function getCalulateDepositFundRequestDTO() {
        return new DepositFundRequestDTO();
    }

    public static function getUserStatisticsDTO() {
        return new UserStatisticsDTO();
    }

    public static function getDepositStatisticsDTO() {
        return new DepositStatisticsDTO();
    }

    public static function getDepositPlanStatisticsDTO() {
        return new DepositPlanStatisticsDTO();
    }

    public static function getWithdrawStatisticsDTO() {
        return new WithdrawStatisticsDTO();
    }

    public static function getDashboardToolbarDTO() {
        return new DashboardToolbarDTO();
    }

    public static function getUserDashboardToolbarDTO() {
        return new UserDashboardToolbarDTO();
    }

    public static function getContactUsDTO() {
        return new ContactUsDTO();
    }

    public static function getSupportDTO($support = null) {
        return new SupportDTO($support);
    }

    public static function getSupportMessageDTO() {
        return new SupportMessageDTO();
    }

    public static function getOpenSupportMessageRequestDTO() {
        return new OpenSupportMessageRequestDTO();
    }

    public static function getManageSubAccountRequestDTO() {
        return new ManageSubAccountRequestDTO();
    }

    public static function getUserLoginDTO() {
        return new UserLoginDTO();
    }

    public static function getUserDetailsDTO() {
        return new UserDetailsDTO();
    }

    public static function getPlanDashboardDTO() {
        return new PlanDashboardDTO();
    }

    public static function getTransactionRequestDTO() {
        return new TransactionRequestDTO();
    }

    public static function getUserBalanceDTO(UserBalance $userBalance = null) {
        return new UserBalanceDTO($userBalance);
    }

    public static function getFileDTO($fileDTO = null) {
        return new FileDTO($fileDTO);
    }

    public static function getRoleDTO($roleDTO = null) {
        return new RoleDTO($roleDTO);
    }

    public static function getSettingDTO() {
        return new SettingDTO();
    }

    public static function getGenericCodeDTO(?GenericCode $genericCode) {
        return new GenericCodeDTO($genericCode);
    }

    public static function getCodeTypeDTO() {
        return new CodeTypeDTO();
    }

}
