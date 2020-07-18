<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model;

use Cap\CustomerRequest\Api\Data\StockInterface;

class Stock extends \Magento\Framework\Model\AbstractModel implements StockInterface
{
    protected $_eventPrefix = 'cap_customer_request_stock';

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
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
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
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Get product_sku
     *
     * @return string
     */
    public function getProductSku()
    {
        return $this->getData(self::PRODUCT_SKU);
    }

    /**
     * Set product_sku
     *
     * @param string $productSku
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductSku($productSku)
    {
        return $this->setData(self::PRODUCT_SKU, $productSku);
    }

    /**
     * Get product_name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * Set product_name
     *
     * @param string $productName
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * Get customer_name
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->getData(self::CUSTOMER_NAME);
    }

    /**
     * Set customer_name
     *
     * @param string $customerName
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }

    /**
     * Get customer_email
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer_email
     *
     * @param string $customerEmail
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
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
     * Set status
     *
     * @param string $status
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
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
     * Set comment
     *
     * @param string $comment
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
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
     * Set created_at
     *
     * @param string $createdAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
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
     * Set updated_at
     *
     * @param string $updatedAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get image_path
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->getData(self::IMAGE_PATH);
    }

    /**
     * Set image_path
     *
     * @param $imagePath
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setImagePath($imagePath)
    {
        return $this->setData(self::IMAGE_PATH, $imagePath);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Cap\CustomerRequest\Model\ResourceModel\Stock::class);
    }
}
