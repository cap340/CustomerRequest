<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Controller\Adminhtml\Stock;

class Delete extends \Cap\CustomerRequest\Controller\Adminhtml\Stock
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\Cap\CustomerRequest\Model\Stock::class);
                $model->load($id);

                // TODO: Delete saved image for the request
                $model->delete();

                $this->messageManager->addSuccessMessage(__('You deleted the request #%1.', $id));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a request to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
