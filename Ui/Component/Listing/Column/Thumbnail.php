<?php

namespace Cap\CustomerRequest\Ui\Component\Listing\Column;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'image';
    const ALT_FIELD = 'name';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Thumbnail constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $relativePath = $this->storeManager->getStore()
                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                $relativePath .= \Cap\CustomerRequest\Helper\Data::REQUEST_MEDIA_DIR;
                $mediaPath = $relativePath . $item['image_path'];
                $item[$fieldName . '_src'] = $mediaPath;
                $item[$fieldName . '_alt'] = $this->getAlt($item);
                $item[$fieldName . '_orig_src'] = $mediaPath;
            }
        }

        return $dataSource;
    }

    /**
     * @param $row
     * @return mixed|null
     */
    protected function getAlt($row)
    {
        $altField = self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
