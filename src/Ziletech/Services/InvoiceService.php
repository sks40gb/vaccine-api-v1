<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\InvoiceDTO;
use Ziletech\Database\Entity\CodeTypeConstant;
use Ziletech\Database\Entity\GenericCodeConstant;
use Ziletech\Util\DateUtil;
use Ziletech\Util\NumberUtil;
use Ziletech\Util\UrlUtil;

class InvoiceService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function printInvoice(int $userId) {
        $template = $this->daoFactory->getGenericCodeDAO()
                ->getByCodeTypeAndCode(CodeTypeConstant::EMAIL_TEMPLATE, GenericCodeConstant::INVOICE);
        $url = $template->getDescription();
        echo UrlUtil::post($url, $this->getInvoiceDTO($userId));
    }

    public function getInvoiceDTO($userId) {
        $user = $this->daoFactory->getUserDAO()->findById($userId);
        $invoiceDTO = new InvoiceDTO();
        $invoiceDTO->setUser(DTOFactory:: getUserDTO($user));
        $invoiceDTO->setPrintDate(DateUtil::getCurrentDate()->format("M d,Y"));
        $depositDTOList = [];
        $grandTotal = 0;
        foreach ($user->getDepositList() as $deposit) {
            $depositDTO = DTOFactory::getDepositDTO($deposit);
            $plan = $this->daoFactory->getPlanDAO()->findById($deposit->getRequestedPlanId());
            $depositDTO->setPlan($plan->getName());
            $grandTotal += +$depositDTO->getNetAmount();
            array_push($depositDTOList, $depositDTO);
        }

        $invoiceDTO->setDepositList($depositDTOList);
        $invoiceDTO->setGrandTotal(sprintf("%.2f", $grandTotal));
        $numberUtil = new NumberUtil();
        $invoiceDTO->setInvoiceNumber($numberUtil->generateNumber(1, 7, "INV-"));
        return $invoiceDTO; 
    }

}
