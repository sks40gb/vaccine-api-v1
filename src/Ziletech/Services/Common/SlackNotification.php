<?php

namespace Ziletech\Services\Common;

use Ziletech\Database\DAO\DAOFactory;
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

    public function appliedForLeave(User $user): void {
        if ($user->getUserConfig()->getAppliedForLeaveNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_APPLIED_FOR_LEAVE)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $this->slackService->sendMessage($message);
        }
    }

    public function pendingEntryToConfirm(User $user, $entryList = []): void {
        $appSlackApi = $this->getTemplate(Slack::APP_SLACK_API);
        if ($this->isNotificationEnabled($appSlackApi, $user) && $user->getUserConfig()->getBlEntryNotification()) {
            $template = $this->getTemplate(Slack::SLACK_TEMPLATE_PENDING_ENTRY_TO_CONFIRM)->getDescription();
            $message = $this->compileSlackId($template, $user->getSlackId());
            $message = $this->compileBlNumbersByStatus($message, $entryList);
            $this->slackService->sendMessage($message);
        }
    }

    private function compileBlNumbers(string $template, $entryList) {
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


    private function compileBlNumber(string $message, string $blNumber) {
        return str_replace("{{blNumber}}", $blNumber, $message);
    }

    private function compileBPOEntryStatus(string $message, string $Status) {
        return str_replace("{{status}}", $Status, $message);
    }

    private function compileBPOEntryPreviousStatus(string $message, string $Status) {
        return str_replace("{{previousStatus}}", $Status, $message);
    }

    private function compileStausId($template, $slackId) {
        return str_replace("{{status}}", $slackId, $template);
    }

    private function compileSlackId($template, $slackId) {
        return str_replace("{{slackId}}", $slackId, $template);
    }

    private function compileAssignedTo(string $message, string $assignToSlackId) {
        return str_replace("{{assignToSlackId}}", $assignToSlackId, $message);
    }

    private function compilePreviousAssignedTo(string $message, string $assignToSlackId) {
        return str_replace("{{previousAssignToSlackId}}", $assignToSlackId, $message);
    }

    private function compileBlComment(string $message, string $comment) {
        return str_replace("{{comment}}", $comment, $message);
    }

    private function compileTimeDifference(string $template, string $timeDifference) {
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
