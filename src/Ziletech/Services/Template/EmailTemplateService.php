<?php

namespace Ziletech\Services\Template;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Util\UrlUtil;

class EmailTemplateService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function getHtmlContent($templateCode, $content): ?EmailTemplate {
        $emailTemplate = $this->daoFactory->getGenericCodeDAO()
                ->getByCodeTypeAndCode(CodeTypeConstant::EMAIL_TEMPLATE, $templateCode);
        $htmlUrl = $emailTemplate->getDescription();
        $htmlContent = UrlUtil::post($htmlUrl, $content);
        $template = new EmailTemplate();
        $template->setContent($htmlContent);
        $template->setSubject($emailTemplate->getField1());
        return $template;
    }

}
