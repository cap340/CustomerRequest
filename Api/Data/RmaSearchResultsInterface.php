<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api\Data;

interface RmaSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Rma list.
     *
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface[]
     */
    public function getItems();

    /**
     * Set product_id list.
     *
     * @param \Cap\CustomerRequest\Api\Data\RmaInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
