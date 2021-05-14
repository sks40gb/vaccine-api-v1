<?php

namespace Ziletech\Database\Entity;

class EntityFactory {

    public static function getPaymentLog() {
        return new PaymentLog();
    }

    public static function getPaymentMethod() {
        return new PaymentMethod();
    }

    public static function getPlan() {
        return new Plan();
    }

    public static function getSubscribe() {
        return new Subscribe();
    }

    public static function getSupport() {
        return new Support();
    }

    public static function getSupportMessage() {
        return new SupportMessage();
    }

    public static function getTestimonial() {
        return new Testimonial();
    }

    public static function getUserBalance() {
        return new UserBalance();
    }

    public static function getTransaction() {
        return new Transaction();
    }

    public static function getUserLogin() {
        return new UserLogin();
    }

    public static function getWithdrawLog() {
        return new Withdraw();
    }

    public static function getWithdrawMethod() {
        return new WithdrawMethod();
    }

    public static function getUser() {
        return new User();
    }

    public static function getUserTree() {
        return new UserTree();
    }

    public static function getIncome() {
        return new Income();
    }

    public static function getSiteConfig() {
        return new SiteConfig();
    }

    public static function getBasicSetting() {
        return new BasicSetting();
    }

    public static function getDeposit() {
        return new Deposit();
    }

    public static function getMigration() {
        return new Migration();
    }

    public static function getFile() {
        return new File();
    }

    public static function getRole() {
        return new Role();
    }

    public static function getUserPosition() {
        return new UserPosition();
    }

    public static function getSetting() {
        return new Setting();
    }

    public static function getGenericCode() {
        return new GenericCode();
    }

    public static function getCodeType() {
        return new CodeType();
    }

}
