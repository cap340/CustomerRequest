<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model;

use Cap\CustomerRequest\Api\Data\RmaInterface;

class Rma extends \Magento\Framework\Model\AbstractModel implements RmaInterface
{
    protected $_eventPrefix = 'cap_customer_request_rma';

    /**
     * Get entity_id
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     *
     * @param string $id
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setEntityId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Get product_id
     *
     * @return string
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set product_id
     *
     * @param string $productId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Get order_id
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set order_id
     *
     * @param string $orderId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get customer_id
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     *
     * @param string $customerId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Cap\CustomerRequest\Model\ResourceModel\Rma::class);
    }
}
