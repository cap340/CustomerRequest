<?php

namespace Cap\CustomerRequest\Model\Stock;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Stock Request Status
     */
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_CLOSED = 3;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_PENDING, 'label' => __('Pending')],
            ['value' => self::STATUS_PROCESSING, 'label' => __('Processing')],
            ['value' => self::STATUS_COMPLETE, 'label' => __('Complete')],
            ['value' => self::STATUS_CLOSED, 'label' => __('Closed')],
        ];
    }
}
