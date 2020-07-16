<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api\Data;

interface StockInterface
{
    const ENTITY_ID = 'entity_id';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_SKU = 'product_sku';
    const PRODUCT_NAME = 'product_name';
    const CUSTOMER_NAME = 'customer_name';
    const CUSTOMER_EMAIL = 'customer_email';
    const MESSAGE = 'message';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const IMAGE_PATH = 'image_path';

    /**
     * Get entity_id
     *
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     *
     * @param string $id
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setEntityId($id);

    /**
     * Get product_id
     *
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     *
     * @param string $productId
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductId($productId);

    /**
     * Get product_sku
     *
     * @return string|null
     */
    public function getProductSku();

    /**
     * Set product_sku
     *
     * @param string $productSku
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductSku($productSku);

    /**
     * Get product_name
     *
     * @return string|null
     */
    public function getProductName();

    /**
     * Set product_name
     *
     * @param string $productName
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setProductName($productName);

    /**
     * Get customer_name
     *
     * @return string|null
     */
    public function getCustomerName();

    /**
     * Set customer_name
     *
     * @param string $customerName
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get customer_email
     *
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     *
     * @param string $customerEmail
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setStatus($status);

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     *
     * @param string $message
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setMessage($message);

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     *
     * @param string $createdAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     *
     * @param string $updatedAt
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getImagePath();

    /**
     * Set updated_at
     *
     * @param $imagePath
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     */
    public function setImagePath($imagePath);
}
