<?php

namespace Ziletech\Services\Plan\Core\Notification;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Services\Email\DBEmailProvider;
use Ziletech\Services\Email\EmailService;
use Ziletech\Services\InvoiceService;
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

    /**
     *
     * @var InvoiceService
     */
    protected $invoiceService;

    public function __construct($daoFactory) {
        $this->emailService = new EmailService(new DBEmailProvider($daoFactory));
        $this->emailTemplateService = new EmailTemplateService($daoFactory);
        $this->invoiceService = new InvoiceService($daoFactory);
        $this->daoFactory = $daoFactory;
    }

    public function sendEmail($toEmailArray, EmailTemplate $template) {
        $this->emailService->send($toEmailArray, $template->getSubject(), $template->getContent());
    }

}
