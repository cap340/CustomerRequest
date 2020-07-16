<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model\ResourceModel\Rma;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Cap\CustomerRequest\Model\Rma::class,
            \Cap\CustomerRequest\Model\ResourceModel\Rma::class
        );
    }
}
