<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Block\Product;

class View extends \Magento\Catalog\Block\Product\View
{
    /**
     * @var \Cap\CustomerRequest\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $stockState;

    /**
     * View constructor.
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Cap\CustomerRequest\Helper\Data $helper
     * @param \Magento\CatalogInventory\Api\StockStateInterface $stockState
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Cap\CustomerRequest\Helper\Data $helper,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->stockState = $stockState;
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getStockRequestLink()
    {
        $attributes = $this->getConfigurableAttributes();
        $result = [];

        foreach ($attributes as $attribute) {
            $result[] = $attribute->getFrontendLabel();
        }

        return __('Can\'t find your %1 ?', implode(', ', $result));
    }

    /**
     * @return string
     */
    public function getFormKey()
    {
        return $this->helper->getFormKey();
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return '/cap_customer_request/product/stockrequestform';
    }

    /**
     * @return mixed
     */
    public function getConfigurableAttributes()
    {
        $order = $this->helper->getAttributesSortingOrder();
        $attributes = $this->getProduct()->getTypeInstance()->getUsedProductAttributes($this->getProduct());

        usort($attributes, function ($a, $b) use ($order) {
            return array_search($a->getAttributeCode(), $order) - array_search($b->getAttributeCode(), $order);
        });

        return $attributes;
    }

    /**
     * @param $attribute
     * @return array
     */
    public function getConfigurableAttributeOptions($attribute)
    {
        $options = [];
        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($this->getOutOfStockChildren() as $product) {
            if (!isset($options[$product->getData($attribute->getAttributeCode())])) {
                $options[$product->getData($attribute->getAttributeCode())] = [
                    'label' => $product->getResource()->getAttribute(
                        $attribute->getAttributeCode()
                    )->getFrontend()->getValue($product),
                    'product_ids' => []
                ];
            }

            $options[$product->getData($attribute->getAttributeCode())]['product_ids'][] = $product->getId();
        }

        return $options;
    }

    /**
     * @return mixed
     */
    public function getOutOfStockChildren()
    {
        return array_filter($this->getProductChildren(), function ($product) {
            $websiteId = $this->getProduct()->getStore()->getWebsiteId();

            return !$this->stockState->verifyStock($product->getId(), $websiteId) ||
                !$this->stockState->getStockQty($product->getId(), $websiteId);
        });
    }

    /**
     * @return mixed
     */
    private function getProductChildren()
    {
        return $this->getProduct()->getTypeInstance()->getUsedProducts($this->getProduct());
    }

    /**
     * @return mixed
     */
    public function getStockComment()
    {
        return $this->helper->getStockComment();
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $isStockRequestEnabled = $this->helper->isStockRequestEnabled();
        $isConfigurable = $this->getProduct()
                ->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE;
        if (!$isConfigurable || !$isStockRequestEnabled) {
            return '';
        }
        if (!count($this->getOutOfStockChildren())) {
            return '';
        }

        return parent::_toHtml();
    }
}
