<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api;

interface StockRepositoryInterface
{
    /**
     * Save Stock
     *
     * @param \Cap\CustomerRequest\Api\Data\StockInterface $stock
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Cap\CustomerRequest\Api\Data\StockInterface $stock);

    /**
     * Retrieve Stock
     *
     * @param string $id
     * @return \Cap\CustomerRequest\Api\Data\StockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Stock matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cap\CustomerRequest\Api\Data\StockSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Stock
     *
     * @param \Cap\CustomerRequest\Api\Data\StockInterface $stock
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Cap\CustomerRequest\Api\Data\StockInterface $stock);

    /**
     * Delete Stock by ID
     *
     * @param string $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
