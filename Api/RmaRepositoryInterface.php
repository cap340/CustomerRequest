<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Api;

interface RmaRepositoryInterface
{
    /**
     * Save Rma
     *
     * @param \Cap\CustomerRequest\Api\Data\RmaInterface $rma
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Cap\CustomerRequest\Api\Data\RmaInterface $rma);

    /**
     * Retrieve Rma
     *
     * @param string $id
     * @return \Cap\CustomerRequest\Api\Data\RmaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Rma matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cap\CustomerRequest\Api\Data\RmaSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Rma
     *
     * @param \Cap\CustomerRequest\Api\Data\RmaInterface $rma
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Cap\CustomerRequest\Api\Data\RmaInterface $rma);

    /**
     * Delete Rma by ID
     *
     * @param string $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
