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
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory
     */
    protected $rmaCollectionFactory;

    /**
     * @var \Cap\CustomerRequest\Model\Rma\ListStatus
     */
    protected $listStatus;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $orderConfig;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    protected $orders;

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
     * @param \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $rmaCollectionFactory
     * @param \Cap\CustomerRequest\Model\Rma\ListStatus $listStatus
     * @param \Magento\Sales\Model\Order\Config $orderConfig
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
        \Cap\CustomerRequest\Model\ResourceModel\Rma\CollectionFactory $rmaCollectionFactory,
        \Cap\CustomerRequest\Model\Rma\ListStatus $listStatus,
        \Magento\Sales\Model\Order\Config $orderConfig,
        array $data = []
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->helper = $helper;
        $this->orderRepository = $orderRepository;
        $this->rmaCollectionFactory = $rmaCollectionFactory;
        $this->listStatus = $listStatus;
        $this->orderConfig = $orderConfig;
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
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getCustomerOrders()
    {
        if (!($customerId = $this->customerSession->getCustomerId())) {
            return false;
        }
        if (!$this->orders) {
            $this->orders = $this->orderCollectionFactory->create($customerId)->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'status',
                ['in' => $this->orderConfig->getVisibleOnFrontStatuses()]
            )->setOrder(
                'created_at',
                'desc'
            );
        }

        return $this->orders;
    }

    /**
     * @param $id
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getOrderById($id)
    {
        return $this->orderRepository->get($id);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return bool
     */
    public function isOrderStatusAllowed(\Magento\Sales\Model\Order $order)
    {
        $allowedStatuses = $this->helper->getOrderAllowedStatus();
        $allowedStatuses = explode(',', $allowedStatuses);
        if (in_array($order->getStatus(), $allowedStatuses)) {
            return true;
        }
        return false;
    }

    /**
     * @param $orderId
     * @return string
     */
    public function getOrderUrl($orderId)
    {
        return $this->getUrl('sales/order/view', ['order_id' => $orderId]);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return array
     */
    public function getOrderItems(\Magento\Sales\Model\Order $order)
    {
        $confTypeCode = \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE;
        $simpleTypeCode = \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE;

        $items = $order->getAllVisibleItems();
        $data = [];

        foreach ($items as $key => $item) {
            if ($item->getProductType() == $confTypeCode) {
                $productOptions = $item->getProductOptions();
                $attributes = $productOptions['attributes_info'];
                $data[$key] = [
                    'sku' => $productOptions['simple_sku'],
                    'fullName' => $productOptions['simple_name'],
                    'name' => $item->getName(), // configurable name
                ];

                $arr = [];
                foreach ($attributes as $attribute) { // product options
                    $arr[] = $attribute['value'];
                }

                $data[$key]['attribute'][] = implode(', ', $arr);

            } elseif ($item->getProductType() == $simpleTypeCode) {
                $data[] = [
                    'sku' => $item->getSku(),
                    'name' => $item->getName()
                ];
            }
        }

        return $data;
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

    /**
     * @param $option
     * @return mixed
     */
    public function getStatusLabel($option)
    {
        return $this->listStatus->toOptionArray()[$option]['label'];
    }
}
