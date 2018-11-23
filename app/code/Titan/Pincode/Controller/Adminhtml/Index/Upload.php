<?php
namespace Titan\Pincode\Controller\Adminhtml\Index;

class Upload extends \Magento\Backend\App\Action
{

    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        //Call page factory to render layout and page content
        $resultPage = $this->resultPageFactory->create();

        //Set the menu which will be active for this page
        $resultPage->setActiveMenu('Titan_Pincode::pincode_upload');

        //Set the header title of grid
        $resultPage->getConfig()->getTitle()->prepend(__('Upload Pincode'));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Pincode'), __('Pincode'));
        $resultPage->addBreadcrumb(__('Pincode Upload'), __('Pincode Upload'));

        return $resultPage;
    }

    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Titan_Pincode::pincode_upload');
    }
}
