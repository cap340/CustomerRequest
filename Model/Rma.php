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
     * Get products_sku
     *
     * @return string
     */
    public function getProductsSku()
    {
        return $this->getData(self::PRODUCTS_SKU);
    }

    /**
     * Set products_sku
     *
     * @param string $productsSku
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setProductsSku($productsSku)
    {
        return $this->setData(self::PRODUCTS_SKU, $productsSku);
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param string $status
     * @return RmaInterface|Rma
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @param string $type
     * @return RmaInterface|Rma
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @param string $comment
     * @return RmaInterface|Rma
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * Get created_at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface|Rma
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface|Rma
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Cap\CustomerRequest\Model\ResourceModel\Rma::class);
    }
}
