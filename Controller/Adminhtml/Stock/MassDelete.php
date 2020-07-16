<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Controller\Adminhtml\Stock;

class MassDelete extends \Cap\CustomerRequest\Controller\Adminhtml\Stock
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Cap\CustomerRequest\Model\ResourceModel\Stock\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassDelete constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Cap\CustomerRequest\Model\ResourceModel\Stock\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Cap\CustomerRequest\Model\ResourceModel\Stock\CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $countDeleteRequest = 0;

        /** @var \Cap\CustomerRequest\Model\Stock $request */
        foreach ($collection->getItems() as $request) {
            $request->delete();
            $countDeleteRequest++;
        }
        if ($countDeleteRequest) {
            $this->messageManager->addSuccessMessage(__('We deleted %1 request(s).', $countDeleteRequest));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }

    /**
     * @return string|null
     */
    protected function getComponentRefererUrl()
    {
        return $this->filter->getComponentRefererUrl() ?: 'urban_request/*/';
    }
}
