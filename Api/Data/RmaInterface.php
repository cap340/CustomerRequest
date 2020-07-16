<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api\Data;

interface RmaInterface
{
    const ENTITY_ID = 'entity_id';
    const PRODUCT_ID = 'product_id';
    const ORDER_ID = 'order_id';
    const CUSTOMER_ID = 'customer_id';

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
     * Get product_id
     *
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     *
     * @param string $productId
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     */
    public function setProductId($productId);

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
}
