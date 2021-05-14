<?php

namespace Ziletech\Services;

use Ziletech\Database\DAO\DAOFactory;
use Ziletech\Database\DTO\DTOFactory;
use Ziletech\Database\DTO\PaymentMethodDTO;
use Ziletech\Database\Entity\EntityFactory;
use Ziletech\Util\DateUtil;

class PaymentMethodService {

    /**
     * @var DAOFactory
     */
    private $daoFactory;

    public function __construct($daoFactory) {
        $this->daoFactory = $daoFactory;
    }

    public function convertToPaymentMethodDTO($payment) {
        $paymentMethodDTO = DTOFactory::getPaymentMethodDTO();
        $paymentMethodDTO->copyFromDomain($payment);
        if ($payment->image) {
            $file = $this->daoFactory->getFileDAO()->findById($payment->image->id);
            $paymentMethodDTO->setImage(DTOFactory:: getFileDTO($file));
        }
        return $paymentMethodDTO;
    }

    public function copyToPaymentMethod($paymentMethod, $paymentMethodDTO) {
        $paymentMethodDTO->copyToDomain($paymentMethod);
        if (isset($paymentMethodDTO->image->id)) {
            $file = $this->daoFactory->getFileDAO()->findById($paymentMethodDTO->image->id);
            $paymentMethod->setImage($file);
        }
    }

    public function savePaymentMethod(PaymentMethodDTO $paymentMethodDTO) {
        $paymentMethod = EntityFactory::getPaymentMethod();
        $this->copyToPaymentMethod($paymentMethod, $paymentMethodDTO);
        $this->daoFactory->getPaymentMethodDAO()->save($paymentMethod);
        return $this->convertToPaymentMethodDTO($paymentMethod);
    }

    public function updatePaymentMethod(PaymentMethodDTO $paymentMethodDTO) {
        $paymentMethod = $this->daoFactory->getPaymentMethodDAO()->findById($paymentMethodDTO->id);
        $this->copyToPaymentMethod($paymentMethod, $paymentMethodDTO);
        $paymentMethod->setUpdatedAt(DateUtil::getCurrentDate());
        $this->daoFactory->getPaymentMethodDAO()->update($paymentMethod);
        return $this->convertToPaymentMethodDTO($paymentMethod);
    }

    public function updateAutometicMethod($paymentMethodList) {
        $paymentMethod = EntityFactory::getPaymentMethod();
        foreach ($paymentMethodList as $paymentMethodDTO) {
            $paymentMethod = $this->daoFactory->getPaymentMethodDAO()->findById($paymentMethodDTO->getId());
            //Copy Payment
            $this->copyToPaymentMethod($paymentMethod, $paymentMethodDTO);
            $paymentMethod->setUpdatedAt(DateUtil::getCurrentDate());
            $this->daoFactory->getPaymentMethodDAO()->update($paymentMethod);
        }
    }

    public function getMenualPaymentMethodList() {
        $paymentMethodList = [];
        foreach ($this->daoFactory->getPaymentMethodDAO()->findAll() as $payment) {
            // @TODO remove remove hard coded value
            if ($payment->getId() != 1 && $payment->getId() != 2 && $payment->getId() != 3 && $payment->getId() != 4) {
                array_push($paymentMethodList, $this->convertToPaymentMethodDTO($payment));
            }
        }
        return $paymentMethodList;
    }

    public function getActiveMenualPaymentMethodList() {
        $paymentMethodList = [];
        foreach ($this->daoFactory->getPaymentMethodDAO()->getActivePaymentMethod() as $payment) {
            array_push($paymentMethodList, $this->convertToPaymentMethodDTO($payment));
        }
        return $paymentMethodList;
    }
    public function allAutometicPaymentMethod() {
       $paymentMethodList = [];
        foreach ($this->daoFactory->getPaymentMethodDAO()->findAll() as $payment) {
            // @TODO remove remove hard coded value
            if ($payment->getId() == 1 || $payment->getId() == 2 || $payment->getId() == 3 || $payment->getId() == 4) {
                array_push($paymentMethodList, $this->convertToPaymentMethodDTO($payment));
            }
        }
        return $paymentMethodList;
    }

}
