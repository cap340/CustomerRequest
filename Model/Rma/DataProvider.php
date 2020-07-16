<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Model\Rma;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;

    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * DataProvider constructor.
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('cap_customer_request_rma');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('cap_customer_request_rma');
        }

        return $this->loadedData;
    }
}
