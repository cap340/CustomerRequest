<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Block\Customer;

use Magento\Framework\Exception\NoSuchEntityException;

class Dashboard extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var \Cap\CustomerRequest\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory
     */
    protected $rmaCollectionFactory;

    /**
     * Dashboard constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Cap\CustomerRequest\Helper\Data $helper
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $rmaCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Cap\CustomerRequest\Helper\Data $helper,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $rmaCollectionFactory,
        array $data = []
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->helper = $helper;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->rmaCollectionFactory = $rmaCollectionFactory;
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        if ($this->customerSession->isLoggedIn()) {
            return true;
        }
        return false;
    }

    /**
     * @return \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrdersCanRequest()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        // TODO: ALLOWED ORDERS
//        $options = $this->helper->getConfigAllowedOrders();
//        $options = explode(',', $options);

        $orders = $this->orderCollectionFactory->create();
        return $orders->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', $customerId)
//            ->addFieldToFilter('status', ['in' => $options])
            ->setOrder('created_at', 'desc');
    }

    /**
     * @param $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    public function getLoadProductBySku($sku)
    {
        try {
            return $this->productRepository->get($sku);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->_logger->error($e->getMessage());
        }

        return null;
    }

    /**
     * @param $id
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getLoadOrderById($id)
    {
        return $this->orderRepository->get($id);
    }

    /**
     * @param $orderId
     * @return bool
     */
    public function isOrderStatusAllowed($orderId)
    {
        $order = $this->getLoadOrderById($orderId);

        $allowedStatuses = $this->helper->getOrderAllowedStatus();
        $allowedStatuses = explode(',', $allowedStatuses);

        foreach ($allowedStatuses as $status) {
            if (in_array($order->getStatus(), $allowedStatuses)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return '/cap_customer_request/customer/rmarequestform';
    }

    /**
     * @param $customerId
     * @return \Cap\CustomerRequest\Model\ResourceModel\Rma\Collection
     */
    public function getRmaCustomerHistory($customerId)
    {
        $collection = $this->rmaCollectionFactory->create();
        return $collection->addFieldToSelect('*')
            ->addFilter('customer_id', $customerId, 'like');
    }
}
