<?php /** @noinspection DuplicatedCode */
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model;

class StockRepository implements \Cap\CustomerRequest\Api\StockRepositoryInterface
{
    /**
     * @var \Cap\CustomerRequest\Model\ResourceModel\Stock
     */
    protected $resource;

    /**
     * @var StockFactory
     */
    protected $stockFactory;

    /**
     * @var \Cap\CustomerRequest\Api\Data\StockSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Cap\CustomerRequest\Api\Data\StockInterfaceFactory
     */
    protected $dataStockFactory;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ResourceModel\Stock\CollectionFactory
     */
    protected $stockCollectionFactory;

    public function __construct(
        \Cap\CustomerRequest\Model\ResourceModel\Stock $resource,
        StockFactory $stockFactory,
        \Cap\CustomerRequest\Api\Data\StockInterfaceFactory $dataStockFactory,
        \Cap\CustomerRequest\Model\ResourceModel\Stock\CollectionFactory $stockCollectionFactory,
        \Cap\CustomerRequest\Api\Data\StockSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->stockFactory = $stockFactory;
        $this->stockCollectionFactory = $stockCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataStockFactory = $dataStockFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Cap\CustomerRequest\Api\Data\StockInterface $stock)
    {
        /* if (empty($stock->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $stock->setStoreId($storeId);
        } */
        try {
            $this->resource->save($stock);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the request: %1',
                $exception->getMessage()
            ));
        }
        return $stock;
    }

    /**
     * {@inheritdoc}
     * @noinspection DuplicatedCode
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $collection = $this->stockCollectionFactory->create();
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
    public function delete(\Cap\CustomerRequest\Api\Data\StockInterface $stock)
    {
        try {
            $this->resource->delete($stock);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__(
                'Could not delete the request: %1',
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
        $stock = $this->stockFactory->create();
        $this->resource->load($stock, $id);
        if (!$stock->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Request %1 does not exist.', $id)
            );
        }
        return $stock;
    }
}
