<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model\Rma;

class ListStatus implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Rma Request Status
     */
    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_PENDING, 'label' => __('Pending')],
            ['value' => self::STATUS_ACCEPTED, 'label' => __('Accepted')],
            ['value' => self::STATUS_REJECTED, 'label' => __('Rejected')]
        ];
    }
}
