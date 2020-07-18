<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api\Data;

interface RmaInterface
{
    const ENTITY_ID = 'entity_id';
    const ORDER_ID = 'order_id';
    const CUSTOMER_ID = 'customer_id';
    const PRODUCTS_SKU = 'products_sku';
    const STATUS = 'status';
    const COMMENT = 'comment';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setEntityId($id);

    /**
     * Get order_id
     *
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     *
     * @param string $orderId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setOrderId($orderId);

    /**
     * Get customer_id
     *
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     *
     * @param string $customerId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get products_sku
     *
     * @return string|null
     */
    public function getProductsSku();

    /**
     * Set products_sku
     *
     * @param string $productsSku
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setProductsSku($productsSku);

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
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setStatus($status);

    /**
     * Get status
     *
     * @return string|null
     */
    public function getComment();

    /**
     * Set status
     *
     * @param string $comment
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setComment($comment);

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
}
