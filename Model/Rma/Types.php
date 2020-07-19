<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model\Rma;

class Types implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Rma Request Status
     */
    const TYPE_REFUND = 1;
    const TYPE_EXCHANGE = 2;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::TYPE_REFUND, 'label' => __('Refund')],
            ['value' => self::TYPE_EXCHANGE, 'label' => __('Exchange')]
        ];
    }
}
