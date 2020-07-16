<?php /** @noinspection DuplicatedCode */

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model;

class RmaRepository implements \Cap\CustomerRequest\Api\RmaRepositoryInterface
{
    /**
     * @var ResourceModel\Rma
     */
    protected $resource;

    /**
     * @var RmaFactory
     */
    protected $rmaFactory;

    /**
     * @var ResourceModel\Rma\CollectionFactory
     */
    protected $rmaCollectionFactory;

    /**
     * @var \Cap\CustomerRequest\Api\Data\RmaSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Cap\CustomerRequest\Api\Data\RmaInterfaceFactory
     */
    protected $dataRmaFactory;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * RmaRepository constructor.
     *
     * @param ResourceModel\Rma $resource
     * @param RmaFactory $rmaFactory
     * @param \Cap\CustomerRequest\Api\Data\RmaInterfaceFactory $dataRmaFactory
     * @param ResourceModel\Rma\CollectionFactory $rmaCollectionFactory
     * @param \Cap\CustomerRequest\Api\Data\RmaSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Cap\CustomerRequest\Model\ResourceModel\Rma $resource,
        RmaFactory $rmaFactory,
        \Cap\CustomerRequest\Api\Data\RmaInterfaceFactory $dataRmaFactory,
        \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $rmaCollectionFactory,
        \Cap\CustomerRequest\Api\Data\RmaSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->rmaFactory = $rmaFactory;
        $this->rmaCollectionFactory = $rmaCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRmaFactory = $dataRmaFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Cap\CustomerRequest\Api\Data\RmaInterface $rma)
    {
        /* if (empty($rma->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $rma->setStoreId($storeId);
        } */
        try {
            $this->resource->save($rma);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the Rma Request: %1',
                $exception->getMessage()
            ));
        }
        return $rma;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->rmaCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }

        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var \Magento\Framework\Api\SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Cap\CustomerRequest\Api\Data\RmaInterface $rma)
    {
        try {
            $this->resource->delete($rma);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__(
                'Could not delete the Rma Request: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $rma = $this->rmaFactory->create();
        $this->resource->load($rma, $id);
        if (!$rma->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Rma Request with id "%1" does not exist.', $id)
            );
        }
        return $rma;
    }
}
