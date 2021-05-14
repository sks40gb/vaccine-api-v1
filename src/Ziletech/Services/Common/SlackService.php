<?php

namespace Ziletech\Services\Common;

use Maknz\Slack\Client;
use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\GenericCode;
use Ziletech\Database\Entity\Slack;

class SlackService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    /**
     *
     * @var GenericCode
     */
    private $setting;
    private $client;

    public function __construct(DAOFactory $daoFactory) {
        $this->daoFactory = $daoFactory;
        $this->setting = $daoFactory->getGenericCodeDAO()->getByCode(Slack::APP_SLACK_API);
        /* $settings = [
          'username' => 'Cyril',
          'channel' => '#timesheet',
          'link_names' => true
          ]; */
        //$slackAPI = "https://hooks.slack.com/services/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";
        $this->client = new Client($this->setting->getDescription());
    }

    public function sendMessage($message) {
        if ($this->setting->getEnabled()) {
            $this->client->send($message);
        }
    }

}
