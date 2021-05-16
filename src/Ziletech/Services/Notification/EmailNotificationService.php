<?php

namespace Ziletech\Services\Notification;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Services\Email\DBEmailProvider;
use Ziletech\Services\Email\EmailService;
use Ziletech\Services\Template\EmailTemplate;
use Ziletech\Services\Template\EmailTemplateService;

class EmailNotificationService {

    /**
     * @var DAOFactory
     */
    protected $daoFactory;

    /**
     *
     * @var EmailService
     */
    protected $emailService;

    /**
     *
     * @var EmailTemplateService
     */
    protected $emailTemplateService;

    public function __construct($daoFactory) {
        $this->emailService = new EmailService(new DBEmailProvider($daoFactory));
        $this->emailTemplateService = new EmailTemplateService($daoFactory);
        $this->daoFactory = $daoFactory;
    }

    public function sendEmail($toEmailArray, EmailTemplate $template) {
        $this->emailService->send($toEmailArray, $template->getSubject(), $template->getContent());
    }

}
