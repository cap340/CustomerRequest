<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api\Data;

interface StockSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Stock list.
     *
     * @return \Cap\CustomerRequest\Api\Data\StockInterface[]
     */
    public function getItems();

    /**
     * Set product_id list.
     *
     * @param \Cap\CustomerRequest\Api\Data\StockInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
