<?php

use Slim\Http\Body;
use Slim\Http\Request;
use Slim\Http\Response;
use Ziletech\Controllers\AuthController;
use Ziletech\Controllers\AutocompleterController;
use Ziletech\Controllers\DashboardController;
use Ziletech\Controllers\DepositController;
use Ziletech\Controllers\DropdownController;
use Ziletech\Controllers\FileController;
use Ziletech\Controllers\GenelogyAdminController;
use Ziletech\Controllers\GenelogyController;
use Ziletech\Controllers\GenericCodeController;
use Ziletech\Controllers\InvoiceController;
use Ziletech\Controllers\PaymentMethodController;
use Ziletech\Controllers\PlanController;
use Ziletech\Controllers\RegisterController;
use Ziletech\Controllers\SettingController;
use Ziletech\Controllers\SiteSettingController;
use Ziletech\Controllers\SupportTicketController;
use Ziletech\Controllers\TransactionController;
use Ziletech\Controllers\UserController;
use Ziletech\Controllers\WithdrawController;
use Ziletech\Controllers\WithdrawMethodController;

// Api Routes
$app->group('/api', function () use ($app) {

    $userAuth = $this->getContainer()->get('jwt');
    $optionalAuth = $this->getContainer()->get('optionalAuth');
    $adminAuth = $this->getContainer()->get('adminAuth');

    /** Admin Routes * */
    $app->group('/admin', function() use ($app) {

        //auth
        $this->get('/auth/sign-in-as/{username}', AuthController::class . ':loginAs');
        //Withdraw 
        $this->get('/withdraw/find/status[/{status}]', WithdrawController::class . ':find');
        $this->get('/withdraw/view-request/{id}', WithdrawController::class . ':viewWithdrawRequest');
        $this->get('/withdraw/approve/{id}', WithdrawController::class . ':approveWithdraw');
        $this->get('/withdraw/refunded/{id}', WithdrawController::class . ':withdrawRefund');

        //withdraw method
        $this->get('/withdraw/view-method', WithdrawMethodController::class . ':getAllMethod');
        $this->post('/withdraw', WithdrawMethodController::class . ':save');
        $this->put('/withdraw', WithdrawMethodController ::class . ':update');

        //Plan
        $this->post('/plan', PlanController::class . ':save');
        $this->put('/plan', PlanController ::class . ':update');
        $this->delete('/plan/{id}', PlanController ::class . ':remove');
        $this->post('/plan/search', PlanController ::class . ':search');

        //support
        $this->get('/support-ticket/all-ticket', SupportTicketController::class . ':getAllSupport');
        $this->post('/support-ticket/answer-to-user-massege', SupportTicketController::class . ':answerToUserMessege');
        $this->get('/support-ticket/pending-support', SupportTicketController::class . ':getAllPendingSupport');

        //Payment method
        $this->get('/payment-method/manual/all', PaymentMethodController::class . ':allManualPaymentMethod');
        $this->post('/payment-method', PaymentMethodController::class . ':save');
        $this->put('/payment-method', PaymentMethodController ::class . ':update');
        $this->delete('/payment-method/{id}', PaymentMethodController ::class . ':remove');
        $this->put('/payment-method/autometic/update', PaymentMethodController ::class . ':updateAutometicMethod');
        $this->get('/payment-method/autometic/all', PaymentMethodController::class . ':allAutometicPaymentMethod');


        //deposit
        $this->get('/deposit/find/status[/{status}]', DepositController::class . ':find');
        $this->get('/deposit/cancel/{id}', DepositController::class . ':cancelDeposit');
        $this->get('/deposit/approve/{id}', DepositController::class . ':approveDeposit');
        $this->get('/deposit/requested/{id}', DepositController::class . ':getDepositRequests');
        $this->post('/deposit/search', DepositController::class . ':search');

        //transaction
        $this->post('/transaction/search', TransactionController ::class . ':search');

        //dashboard
        $this->get('/dashboard/statistics/user', DashboardController::class . ':getUserStatistics');
        $this->get('/dashboard/statistics/deposit', DashboardController::class . ':getDepositStatistics');
        $this->get('/dashboard/statistics/deposit-plan', DashboardController::class . ':getDepositPlanStatistics');
        $this->get('/dashboard/statistics/withdraw', DashboardController::class . ':getWithdrawStatistics');
        $this->get('/dashboard/toolbar', DashboardController::class . ':getDashboardToolbar');


        //user
        $this->get('/user/{id}', UserController ::class . ':get');
        $this->delete('/user/{id}', UserController ::class . ':remove');
        $this->get('/user/status/change/{id}/{status}', UserController ::class . ':setUserStatus');
        $this->post('/user/search', UserController ::class . ':search');
        $this->post('/user/save-balance', UserController ::class . ':saveUserBalance');
        $this->get('/user/activate/{username}', UserController ::class . ':activateUser');

        //setting
        $this->get('/setting/{type}', SettingController::class . ':get');
        $this->put('/setting/{type}', SettingController::class . ':update');

        //site setting
        $this->post('/site-setting', SiteSettingController::class . ':save');
        $this->put('/site-setting', SiteSettingController ::class . ':update');
        $this->delete('/site-setting/{id}', SiteSettingController ::class . ':remove');
        $this->get('/site-setting/find/all', SiteSettingController ::class . ':search');
        $this->get('/site-setting/general', SiteSettingController ::class . ':getGeneralSetting');
        $this->get('/site-setting/{id}', SiteSettingController ::class . ':get');

        // Register
        $this->post('/register', RegisterController::class . ':registerAndActivate');

        // Generic Code
        $this->get('/generic-code/{id}', GenericCodeController ::class . ':get');
        $this->post('/generic-code/find', GenericCodeController ::class . ':find');
        $this->post('/generic-code', GenericCodeController ::class . ':save');
        $this->put('/generic-code', GenericCodeController ::class . ':update');
        $this->delete('/generic-code/{id}', GenericCodeController ::class . ':remove');

        // genelogy
        $this->get('/genelogy/smart-tables/{username}', GenelogyAdminController::class . ':getUserSmartTables');
        $this->get('/genelogy/tree/multi/{username}/depth/{depth}', GenelogyController::class . ':getMultipleUserTree');
        $this->get('/genelogy/tree/referral/{username}/depth/{depth}', GenelogyAdminController::class . ':getReferralUserTree');
        $this->get('/genelogy/referral/direct/{username}', GenelogyAdminController::class . ':getDirectReferralList');
        $this->get('/genelogy/referral/team/{username}', GenelogyAdminController::class . ':getTeamReferralList');
        $this->get('/genelogy/global/tree/level/{level}/depth/{depth}/{username}', GenelogyController::class . ':getAdminGlobalUserTree');
        $this->get('/genelogy/global/{username}', GenelogyController::class . ':getGlobalAdminTables');
    })->add($adminAuth)->add($userAuth);

    // User Routes
    $app->group('', function() use ($app) {

        //autocompleter
        $this->get('/autocompleter/table/get/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/{table}/{column}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/query/{queryName}/{searchText}', AutocompleterController::class . ':findByQuery');
        $this->get('/autocompleter/query/{queryName}', AutocompleterController::class . ':findByQuery');
        $this->get('/autocompleter/table/find/{table}/{column}/{searchText}', AutocompleterController::class . ':findByTableAndColumn');
        $this->get('/autocompleter/table/find/{table}/{column}', AutocompleterController::class . ':findByTableAndColumn');

        //Dropdown
        $this->get('/dropdown/type/{code}', DropdownController::class . ':type');
        $this->get('/dropdown/codetype/{code}', DropdownController::class . ':type');
        $this->get('/dropdown/genericcode/bycodetype/{code}', DropdownController::class . ':findGeneriCodeByCodeType');

        /* Withdraw API */

        $this->get('/withdraw/charges', WithdrawController::class . ':getAdminAndTDSCharges');
        $this->get('/withdraw/find/status[/{status}]', WithdrawController::class . ':findForCurrentUser');
        $this->post('/withdraw/save', WithdrawController::class . ':save');
        $this->get('/withdraw/minimum', WithdrawController::class . ':minimumWithdraw');

        //withdraw method 
        $this->get('/withdraw/view-active-method', WithdrawMethodController::class . ':getWithdrawMethodsForuser');
        $this->get('/withdraw/{id}', WithdrawMethodController::class . ':get');

        //support ticket
        $this->get('/support-ticket/all', SupportTicketController::class . ':getCurrentUserSupport');
        $this->post('/support-ticket/create', SupportTicketController::class . ':createNewTicket');
        $this->get('/support-ticket/{id}', SupportTicketController::class . ':get');
        $this->post('/support-ticket/massege/save', SupportTicketController::class . ':saveUserMessage');
        $this->get('/support-ticket/close/{id}', SupportTicketController::class . ':closeSupport');
        $this->get('/support-ticket/message/{ticket}', SupportTicketController::class . ':getSupportMessegeByTicket');

        //payment method
        $this->get('/payment-method/manual/active', PaymentMethodController::class . ':allActiveManualPaymentMethod');
        $this->get('/payment-method/{id}', PaymentMethodController::class . ':get');


        //deposit
        $this->get('/deposit/find/status[/{status}]', DepositController::class . ':findForCurrentUser');
        $this->post('/deposit/save', DepositController::class . ':save');
        $this->get('/deposit/user-status', DepositController::class . ':getStatus');

        //file
        $this->post('/file/upload', FileController::class . ':upload');
        $this->delete('/file/{id}', FileController::class . ':delete');

        //transaction
        $this->get('/transaction/search', TransactionController ::class . ':searchCurrentUserTransaction');

        //dashboard 
        $this->get('/dashboard/toolbar', DashboardController::class . ':getUserDashboardToolbar');

        //user 
        $this->get('/user/by-login-name/{loginName}', UserController ::class . ':getByLoginName');
        $this->get('/user/confirm/{id}', UserController ::class . ':setConfirmStatus');
        $this->get('/user/new/{id}', UserController ::class . ':getNewUserList');
        $this->get('/user/balance/{id}', UserController ::class . ':getUserBalance');
        $this->get('/user/available-balance', UserController ::class . ':getBalance');
        $this->put('/user', UserController ::class . ':update');
        $this->get('/user/profile', UserController ::class . ':myProfile');
        $this->get('/auth/current/refresh', AuthController::class . ':refreshCurrentUser');


        // genelogy
        $this->get('/genelogy/smart-tables', GenelogyController::class . ':getUserSmartTables');
        $this->get('/genelogy/tree/level/{level}/depth/{depth}', GenelogyController::class . ':getUserTree');
        $this->get('/genelogy/global/tree/level/{level}/depth/{depth}', GenelogyController::class . ':getGlobalUserTree');
        $this->get('/genelogy/global/upline/tree/level/{level}/{username}', GenelogyController::class . ':getUplineGlobalTree');
        $this->get('/genelogy/global', GenelogyController::class . ':getGlobalUserTables');
        $this->get('/genelogy/tree/multi/depth/{depth}', GenelogyController::class . ':getMultipleUserTree');
        $this->get('/genelogy/tree/referral/{username}/depth/{depth}', GenelogyController::class . ':getReferralUserTreeByUserName');
        $this->get('/genelogy/tree/referral/depth/{depth}', GenelogyController::class . ':getReferralUserTree');
        $this->get('/genelogy/referral/direct', GenelogyController::class . ':getDirectReferralList');
        $this->get('/genelogy/referral/team', GenelogyController::class . ':getTeamReferralList');

        //plan
        $this->get('/plan/user', PlanController::class . ':getCurrentUserPlan');
        $this->get('/plan/{id}', PlanController::class . ':get');
    })->add($userAuth);

    // Anonymous Routes
    $app->group('', function() use ($app) {
        $this->post('/dropdown/common', DropdownController::class . ':codeTypeByPost');
        $this->post('/auth/sign-in', AuthController::class . ':login')->setName('auth.login');
        $this->post('/auth/request-pass', AuthController::class . ':requestPassword')->setName('auth.requestPassword');
        $this->put('/auth/reset-pass', AuthController::class . ':resetPassword')->setName('auth.resetPassword');
        $this->get('/file/download/{id}', FileController::class . ':download');
        //Register
        $this->post('/register', RegisterController::class . ':register');
        //sponser
        $this->get('/user/sponser/{referralId}', UserController ::class . ':getSponserByReferralId');
        $this->get('/user/sponser/by-username/{name}', UserController ::class . ':getSponserByUserName');
        $this->get('/user/validate/{name}', UserController ::class . ':validateUserName');
        //invoice 
        $this->get('/invoice/generate/{userId}', InvoiceController::class . ':generateInvoice');
        $this->get('/genelogy/tree/{username}/level/{level}/depth/{depth}', GenelogyAdminController::class . ':getUserTree');
    });
});

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


//remove the NULL values from the response.
$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);

    if ($response->getHeaderLine('Content-type') == 'application/json;charset=utf-8') {
        $content = (string) $response->getBody();
        $newBody = new Body(fopen('php://temp', 'r+'));
        $newBody->write(preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $content));
        $response = $response->withBody($newBody);
    }
    return $response;
});
