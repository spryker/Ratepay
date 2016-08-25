<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Ratepay\Business\Api\Mapper;

use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

class OrderPaymentInitMapper extends BaseMapper
{

    /**
     * @var \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    protected $orderEntity;

    /**
     * @var \Generated\Shared\Transfer\RatepayPaymentInitTransfer
     */
    protected $ratepayPaymentInitTransfer;

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     */
    public function __construct(
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        SpySalesOrder $orderEntity
    ) {
        $this->ratepayPaymentInitTransfer = $ratepayPaymentInitTransfer;
        $this->orderEntity = $orderEntity;
    }

    /**
     * @return void
     */
    public function map()
    {
        if (
            $this->orderEntity->getSpyPaymentRatepays() &&
            count($this->orderEntity->getSpyPaymentRatepays()->getData())
        ) {
            /** @var \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $paymentRatepayEntity */
            $paymentRatepayEntity = $this->orderEntity->getSpyPaymentRatepays()->getData()[0];
            $this->ratepayPaymentInitTransfer
                ->setPaymentMethodName($paymentRatepayEntity->getPaymentType())
                ->setTransactionId($paymentRatepayEntity->getTransactionId())
                ->setTransactionShortId($paymentRatepayEntity->getTransactionShortId())
                ->setDeviceFingerprint($paymentRatepayEntity->getDeviceFingerprint())
            ;
        }

        $this->ratepayPaymentInitTransfer
            ->setCustomerId($this->orderEntity->getCustomer()->getIdCustomer())
        ;
    }

}
