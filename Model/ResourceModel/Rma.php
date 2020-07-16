<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model\ResourceModel;

class Rma extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('cap_customer_request_rma', 'entity_id');
    }
}
