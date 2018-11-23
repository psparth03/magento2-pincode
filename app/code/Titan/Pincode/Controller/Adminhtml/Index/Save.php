<?php

namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Titan\Pincode\Model\ItemFactory;

class Save extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * pincode model factory
     *
     * @var \Titan\Pincode\Model\ItemFactory
     */
    protected $_itemFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ItemFactory $itemFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_itemFactory = $itemFactory;
    }


    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $itemModel = $this->_itemFactory->create();
            $pincodeId = $this->getRequest()->getParam('id');

            if ($pincodeId) {
                $itemModel->load($pincodeId);
            }
            $formData = $this->getRequest()->getParams();

            $itemModel->setData($formData);

            try {
                // Save pincode
                $itemModel->save();

                // Display success message
                $this->messageManager->addSuccess(__('The pincode has been saved.'));

                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $itemModel->getId(), '_current' => true]);
                    return;
                }

                // Go to grid page
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($formData);
            $this->_redirect('*/*/edit', ['id' => $pincodeId]);
        }
    }
}