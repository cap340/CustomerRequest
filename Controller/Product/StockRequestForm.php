<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Controller\Product;

class StockRequestForm extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Cap\CustomerRequest\Helper\Data
     */
    protected $helper;

    /**
     * @var \Cap\CustomerRequest\Model\StockFactory
     */
    protected $requestStockFactory;

    /**
     * @var \Cap\CustomerRequest\Helper\Email
     */
    protected $emailSender;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * StockRequestForm constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cap\CustomerRequest\Helper\Data $helper
     * @param \Cap\CustomerRequest\Model\StockFactory $requestStockFactory
     * @param \Cap\CustomerRequest\Helper\Email $emailSender
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cap\CustomerRequest\Helper\Data $helper,
        \Cap\CustomerRequest\Model\StockFactory $requestStockFactory,
        \Cap\CustomerRequest\Helper\Email $emailSender,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->helper = $helper;
        $this->requestStockFactory = $requestStockFactory;
        $this->emailSender = $emailSender;
        $this->dateTime = $dateTime;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
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
            try {
                /** @var \Magento\Catalog\Model\Product $product */
                $product = $this->helper->getLoadProduct($post['productId']);
                $model = $this->requestStockFactory->create();

                $model->setProductId($product->getId());
                $model->setProductSku($product->getSku());
                $model->setProductName($product->getName());
                $model->setImagePath($product->getImage());
                $model->setCustomerName($post['customerName']);
                $model->setCustomerEmail($post['customerEmail']);
                $model->setComment($post['comment']);
                $model->setStatus(\Cap\CustomerRequest\Model\Stock\ListStatus::STATUS_PENDING);
                $model->save();

                $this->helper->saveProductImage($product->getImage(), 200);

                $emailData = [
                    'requestId' => $model->getEntityId(),
                    'customerName' => $post['customerName'],
                    'customerEmail' => $post['customerEmail'],
                    'comment' => $post['comment'],
                    'productSku' => $product->getSku(),
                    'productName' => $product->getName(),
                    'createdAt' => $this->dateTime->gmtDate(),
                ];
                $this->emailSender->sendEmailAdmin($emailData);

                $this->messageManager->addSuccessMessage(
                    __('You\'re request have been submitted.')
                );
                return $resultRedirect->setRefererOrBaseUrl();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setRefererOrBaseUrl();
            }
        }

        $this->_view->loadLayout();
        $this->_view->renderLayout();

        // TODO: missing return statement
    }
}
