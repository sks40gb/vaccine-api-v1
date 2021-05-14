<?php

namespace Ziletech\Database\DAO;

use BaseDAO;

class StatusType extends BaseDAO {

    const USER_STATUS = 1;
    const EMAIL_STATUS = 0;
    const PHONE_STATUS = 0;
    const DEPOSIT_PENDING_STATUS = 0;
    const ACTIVE_PLAN_STATUS = 1;
    const DEACTIVE_PLAN_STATUS = 0;
    const PENDING_WITHDRAW_STATUS = 1;
    const WITHHDRAW_REQUEST_AMOUNT_TYPE = 5;
    const WITHHDRAW_REQUEST_CHARGE_TYPE = 10;
    const WITHHDRAW_REFUNDED = 6;
    const REFUNDED_WITHDRAW_STATUS = 3;
    const SUCCESS_WITHDRAW_STATUS = 2;
    const PENDING_SUPPORT_STATUS = 3;
    const ANSWERED_STATUS = 2;
    const CUSTOMER_REPLY_STATUS = 3;
    const SUPPORT_CLOSE_STATUS = 9;
    const SUPPORT_STATUS = 3;
    const COMPLETE_STATUS = 2;
    const ADMIN_TYPE = 2;
    const USER_TYPE = 1;
    const BASIC_SETTING_ID = 1;
    const GENERAL_SETTING_ID = 1;
    const DEPOSIT_APPROVE_STATUS = 1;
    const DEPOSIT_CANCEL_STATUS = 2;
    const DEPOSIT_AMOUNT_TYPE = 1;
    const PLAN_ACTIVE = 2;
    const TICKET_OPENED_STATUS = 1;
    const USER_ACTIVE = 1;
    const USER_DEACTIVE = 2;
    const NEW_USER = 0;

}
