<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Block\Customer;

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
     * Dashboard constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Cap\CustomerRequest\Helper\Data $helper
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
        array $data = []
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->helper = $helper;
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
//        $options = $this->helper->getConfigAllowedOrders();
//        $options = explode(',', $options);

        $orders = $this->orderCollectionFactory->create();
        return $orders->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', $customerId)
//            ->addFieldToFilter('status', ['in' => $options])
            ->setOrder('created_at', 'desc');
    }
}
