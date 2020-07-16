<?php

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
     * StockRequestForm constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Cap\CustomerRequest\Helper\Data $helper
     * @param \Cap\CustomerRequest\Model\StockFactory $requestStockFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cap\CustomerRequest\Helper\Data $helper,
        \Cap\CustomerRequest\Model\StockFactory $requestStockFactory
    ) {
        $this->helper = $helper;
        $this->requestStockFactory = $requestStockFactory;
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
                $model->setMessage($post['message']);
                $model->setStatus(\Cap\CustomerRequest\Model\Stock\Status::STATUS_PENDING);
                $model->save();

                $this->helper->saveProductImage($product->getImage(), 200);

                // TODO: EMAIL SENDER FROM HELPER

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
