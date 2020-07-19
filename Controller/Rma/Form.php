<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Controller\Rma;

class Form extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Cap\CustomerRequest\Model\RmaFactory
     */
    protected $rmaRequestFactory;

    /**
     * @var \Cap\CustomerRequest\Helper\Data
     */
    protected $helper;

    /**
     * RmaRequestForm constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cap\CustomerRequest\Model\RmaFactory $rmaRequestFactory
     * @param \Cap\CustomerRequest\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cap\CustomerRequest\Model\RmaFactory $rmaRequestFactory,
        \Cap\CustomerRequest\Helper\Data $helper
    ) {
        $this->rmaRequestFactory = $rmaRequestFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if (!$this->helper->getFormKeyValidation($this->getRequest())) {
            $this->messageManager->addErrorMessage('Invalid request!');
            return $resultRedirect->setRefererOrBaseUrl();
        }

        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {
            foreach ($post['orderId'] as $key => $val) {
                if (isset($post['submit'][$key])) {
                    $model = $this->rmaRequestFactory->create();
                    $model->setOrderId($post['orderId'][$key]);
                    $model->setCustomerId($post['customerId'][$key]);
                    $model->save();
                }
            }
        }

        return $resultRedirect->setRefererOrBaseUrl();
    }
}
