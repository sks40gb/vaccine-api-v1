<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\BPOEntryCommentDTO;
use Ziletech\Database\DTO\BPOEntryDTO;
use Ziletech\Database\DTO\ExpenseDTO;
use Ziletech\Database\DTO\LeaveRequestDTO;
use Ziletech\Database\Entity\BPOEntry;
use Ziletech\Database\Entity\Expense;
use Ziletech\Database\Entity\Leave;
use Ziletech\Database\Entity\Slack;
use Ziletech\Database\Entity\User;

class SlackNotification {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /**
     *
     * @var SlackService
     */
    private $slackService;

    /**
     * 
     * @param DAOFactory $daoFactory
     */
    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->slackService = new SlackService($daoFactory);
    }

    public function appliedForLeave(User $user) {
        if ($user->getUserConfig()->getAppliedForLeaveNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_APPLIED_FOR_LEAVE)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $this->slackService->sendMessage($message);
        }
    }

    public function leaveStatusChange(Leave $leaveRequest, LeaveRequestDTO $leaveRequestDTO, User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getLeaveStatusChangeNotification() && $leaveRequest->getStatus() != $leaveRequestDTO->getStatus()) { {
                $template = $this->getTemplate(Slack::SLACK_TEMPLATE_FOR_LEAVE_STATUS_CHANGE)->getDescription();
                $message = $this->compileSlackId($template, $user->getSlackId());
                $message = $this->compileStausId($message, $leaveRequestDTO->getStatus());
                $this->slackService->sendMessage($message);
            }
        }
    }

    public function createBlEntries($entryList = [], User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_CREATE_BL_ENTRIES)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumbers($message, $entryList);
            $this->slackService->sendMessage($message);
        }
    }

    public function createExpense(User $user) {
        if ($user->getUserConfig()->getCreateExpenseNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_FOR_CREATED_EXPENSE)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $this->slackService->sendMessage($message);
        }
    }

    public function updateBlEntry(BPOEntry $bpoEntry, BPOEntryDTO $bpoEntryDTO, User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            // for update status $user->getUserConfig()->getBlEntryNotif
            if ($bpoEntry->getStatus()->getId() != $bpoEntryDTO->getStatus()->getId()) {
                $template = $this->getTemplate(Slack::SLACK_TEMPLATE_BL_ENTRIES_STAUS_UPDATE)->getDescription();
                $message = $this->compileSlackId($template, $user->getSlackId());
                $message = $this->compileBlNumber($message, $bpoEntryDTO->getBlNumber());
                $genericode = $this->daoFactory->getGenericCodeDAO()->findById($bpoEntryDTO->getStatus()->getId());
                $message = $this->compileBPOEntryStatus($message, $genericode->getDescription());
                $message = $this->compileBPOEntryPreviousStatus($message, $bpoEntry->getStatus()->getDescription());
                $this->slackService->sendMessage($message);
            }
            //                 for update assigned 
            if ($bpoEntry->getAssignedTo() != null) {
                if ($bpoEntry->getAssignedTo()->getId() != $bpoEntryDTO->getAssignedTo()->getId()) {
                    $template = $this->getTemplate(Slack::SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_UPDATE)->getDescription();
                    $message = $this->compileSlackId($template, $user->getSlackId());
                    $message = $this->compileBlNumber($message, $bpoEntryDTO->getBlNumber());
                    $assignedTo = $this->daoFactory->getUserDAO()->findById($bpoEntryDTO->getAssignedTo()->getId());
                    $message = $this->compileAssignedTo($message, $assignedTo->getSlackId());
                    $message = $this->compilePreviousAssignedTo($message, $bpoEntry->getAssignedTo()->getSlackId());
                    $this->slackService->sendMessage($message);
                }
            } //for assigned first time
            else if ($bpoEntryDTO->getAssignedTo() != null) {
                $template = $this->getTemplate(Slack::SLACK_TEMPLATE_BL_ENTRIES_ASSIGN_TO_DEFAULT)->getDescription();
                $message = $this->compileSlackId($template, $user->getSlackId());
                $message = $this->compileBlNumber($message, $bpoEntryDTO->getBlNumber());
                $assignedTo = $this->daoFactory->getUserDAO()->findById($bpoEntryDTO->getAssignedTo()->getId());
                $message = $this->compileAssignedTo($message, $assignedTo->getSlackId());
                $this->slackService->sendMessage($message);
            }
        }
    }

    public function entryComment(String $blNumber, User $user, BPOEntryCommentDTO $commentDTO) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryCommentNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_BL_ENTRY_COMMENT)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumber($message, $blNumber);
            $message = $this->compileBlComment($message, $commentDTO->getComment());
            $this->slackService->sendMessage($message);
        }
    }

    public function removeMultipleEntry($multipleEntryList = [], User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_DELETE_MULTIPLE_BL_ENTRIES)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumbers($message, $multipleEntryList);
            $this->slackService->sendMessage($message);
        }
    }

    public function removeBpoEntry(BPOEntry $entry, User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_DELETE_BL_ENTRY)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumber($message, $entry->getBlNumber());
            $this->slackService->sendMessage($message);
        }
    }

    public function punchIn(User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getPunchInNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_PUNCH_IN)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $this->slackService->sendMessage($message);
        }
    }

    public function punchOut(User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getPunchOutNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_PUNCH_OUT)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $this->slackService->sendMessage($message);
        }
    }

    public function latePunchIn(User $user, String $timeDifference) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getLatePunchInNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_LATE_PUNCH_IN)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileTimeDifference($message, $timeDifference);
            $user->setLateCount($user->getLateCount() + 1);
            $this->slackService->sendMessage($message);
        }
    }

    public function employeeAbsense(User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getEmployeeAbsenseNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_EMPLOYEE_ABSENSE)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $user->setAbsentCount($user->getAbsentCount() + 1);
            $this->slackService->sendMessage($message);
        }
    }

    public function forgotToPunchOut(User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getForgotToPunchOutNotification()) {
            $template = $this->getTemplate(Slack::SLACK_FORGOT_TO_PUNCH_OUT)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $user->setMissedPunchoutCount($user->getMissedPunchoutCount() + 1);
            $this->slackService->sendMessage($message);
        }
    }

    public function pendingEntryToConfirm(User $user, $entryList = []) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_PENDING_ENTRY_TO_CONFIRM)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumbersByStatus($message, $entryList);
            $this->slackService->sendMessage($message);
        }
    }

    public function expenseStatusChange(Expense $expense, ExpenseDTO $expenseDTO, User $user) {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($appSlackApi->getEnabled() && $user->getUserConfig() != null &&
                $user->getUserConfig()->getExpenseStatusChangeNotification() != null &&
                $expense->getStatus() != $expenseDTO->getStatus()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_FOR_EXPENSE_STATUS_CHANGE)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileStausId($message, $expenseDTO->getStatus());
            $this->slackService->sendMessage($message);
        }
    }

    private function compileBlNumbers(String $template, $entryList) {
        $blNumbers = [];
        foreach ($entryList as $entry) {
            array_push($blNumbers, $entry->getBlNumber());
        }
        $blNumberString = array_pop($blNumbers);

        if ($blNumbers) {
            $blNumberString = implode(', ', $blNumbers) . " and " . $blNumberString;
        }
        return str_replace("{{blNumbers}}", $blNumberString, $template);
    }

    private function compileBlNumbersByStatus(String $template, $entryList) {
        $blNumbers = [];
        $blNumberString = "";
        foreach ($entryList as $entry) {
            array_push($blNumbers, $entry->getBlNumber());
        }
        foreach ($blNumbers as $eachBlNumber) {
            $blNumberString .= $eachBlNumber;
            $blNumberString .= " ,";
        }
        return str_replace("{{blNumbers}}", $blNumberString, $template);
    }

    private function compileBlNumber(String $message, String $blNumber) {
        return str_replace("{{blNumber}}", $blNumber, $message);
    }

    private function compileBPOEntryStatus(String $message, String $Status) {
        return str_replace("{{status}}", $Status, $message);
    }

    private function compileBPOEntryPreviousStatus(String $message, String $Status) {
        return str_replace("{{previousStatus}}", $Status, $message);
    }

    private function compileStausId($template, $slackId) {
        return str_replace("{{status}}", $slackId, $template);
    }

    private function compileSlackId($template, $slackId) {
        return str_replace("{{slackId}}", $slackId, $template);
    }

    private function compileAssignedTo(String $message, String $assignToSlackId) {
        return str_replace("{{assignToSlackId}}", $assignToSlackId, $message);
    }

    private function compilePreviousAssignedTo(String $message, String $assignToSlackId) {
        return str_replace("{{previousAssignToSlackId}}", $assignToSlackId, $message);
    }

    private function compileBlComment(String $message, String $comment) {
        return str_replace("{{comment}}", $comment, $message);
    }

    private function compileTimeDifference(String $template, String $timeDifference) {
        return str_replace("{{duration}}", $timeDifference, $template);
    }

    function isNotificationEnabled($appSlackApi, $user) {
        return $appSlackApi->getEnabled() && $user->getUserConfig() != null && $user->getUserConfig();
    }

    public function getTemplate($code) {
        $template = $this->daoFactory->getGenericCodeDAO()->getByCode($code);
        if (isset($template)) {
            return $template;
        } else {
            return null;
        }
    }

}
