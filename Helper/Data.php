<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_MODULE_ENABLED = 'cap_customer_request/general/enable';
    const REQUEST_MEDIA_DIR = 'customer_request/product';
    /**
     * Stock request configuration
     */
    const XML_PATH_STOCK_REQUEST_ENABLED = 'cap_customer_request/stock/enable';
    const XML_PATH_STOCK_ATTRIBUTES_SORTING_ORDER = 'cap_customer_request/stock/attributes_sorting_order';
    const XML_PATH_STOCK_COMMENT = 'cap_customer_request/stock/comment';
    /**
     * Rma request configuration
     */
    const XML_PATH_RMA_REQUEST_ENABLED = 'cap_customer_request/rma/enable';
    const XML_PATH_RMA_CONDITIONS_LINK = 'cap_customer_request/rma/conditions_link';
    const XML_PATH_RMA_ALLOWED_STATUS = 'cap_customer_request/rma/allowed_orders';
    const XML_PATH_RMA_POPUP_MESSAGE = 'cap_customer_request/rma/popup_message';

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $imageFactory;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory
    ) {
        $this->formKey = $formKey;
        $this->formKeyValidator = $formKeyValidator;
        $this->productRepository = $productRepository;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->imageFactory = $imageFactory;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MODULE_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isStockRequestEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_STOCK_REQUEST_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isRmaRequestEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RMA_REQUEST_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getStockComment()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STOCK_COMMENT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getRmaConditionsLink()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RMA_CONDITIONS_LINK,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getOrderAllowedStatus()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RMA_ALLOWED_STATUS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getRmaPopupMessage()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RMA_POPUP_MESSAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array
     */
    public function getAttributesSortingOrder()
    {
        $rawValue = $this->scopeConfig->getValue(
            self::XML_PATH_STOCK_ATTRIBUTES_SORTING_ORDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return array_map('trim', explode(',', $rawValue));
    }

    /**
     * @param $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLoadProduct($productId)
    {
        return $this->productRepository->getById($productId);
    }

    /**
     * @param $imagePath
     * @param null $width
     * @param null $height
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Exception
     */
    public function saveProductImage($imagePath, $width = null, $height = null)
    {
        $sourceDir = 'catalog/product';
        $destDir = self::REQUEST_MEDIA_DIR;

        if (!$this->mediaDirectory->isDirectory($destDir)) {
            $this->mediaDirectory->create($destDir);
        }
        if (!$this->mediaDirectory->isExist($destDir . $imagePath)) {
            $resize = $this->imageFactory->create();
            $resize->open($this->mediaDirectory->getAbsolutePath($sourceDir) . $imagePath);
            $resize->constrainOnly(true);
            $resize->keepTransparency(true);
            $resize->keepFrame(false);
            $resize->keepAspectRatio(true);
            $resize->resize($width, $height);
            $resize->save($this->mediaDirectory->getAbsolutePath($destDir) . $imagePath);
        }

        return $this->_urlBuilder->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $destDir . $imagePath;
    }

    /**
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @param $request
     * @return bool
     */
    public function getFormKeyValidation($request)
    {
        return $this->formKeyValidator->validate($request);
    }
}
