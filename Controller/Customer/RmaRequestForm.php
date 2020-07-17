<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Controller\Customer;

class RmaRequestForm extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Cap\CustomerRequest\Model\RmaFactory
     */
    protected $rmaFactory;

    /**
     * @var \Cap\CustomerRequest\Helper\Data
     */
    protected $helper;

    /**
     * RmaRequestForm constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cap\CustomerRequest\Model\RmaFactory $rmaFactory
     * @param \Cap\CustomerRequest\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cap\CustomerRequest\Model\RmaFactory $rmaFactory,
        \Cap\CustomerRequest\Helper\Data $helper
    ) {
        $this->rmaFactory = $rmaFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
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
            print_r($post);
        }

        $this->_view->loadLayout();
        $this->_view->renderLayout();

        // TODO: missing return statement
    }
}
