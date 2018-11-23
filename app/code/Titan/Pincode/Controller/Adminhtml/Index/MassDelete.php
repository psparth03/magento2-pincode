<?php

namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Titan\Pincode\Model\ItemFactory;

class MassDelete extends Action
{

    protected $_coreRegistry;

    protected $_resultPageFactory;

    protected $_itemFactory;

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
        // Get IDs of the selected pincode
        $pincodeIds = $this->getRequest()->getParam('pincode');

        foreach ($pincodeIds as $pincodeId) {
            try {
                /** @var $pincodeModel \Titan\Pincode\Model\Item */
                $pincodeModel = $this->_itemFactory->create();
                $pincodeModel->load($pincodeId)->delete();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        if (count($pincodeIds)) {
            $this->messageManager->addSuccess(
                __('A total of %1 record(s) were deleted.', count($pincodeIds))
            );
        }

        $this->_redirect('*/*/index');
    }
}