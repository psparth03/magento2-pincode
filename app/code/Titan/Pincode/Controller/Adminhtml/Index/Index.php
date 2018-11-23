<?php

namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Titan_Pincode::pincode');
        $resultPage->getConfig()->getTitle()->prepend((__('Pincode')));
        $resultPage->addBreadcrumb(__('Pincode'), __('Pincode'));
        $resultPage->addBreadcrumb(__('Pincode Upload'), __('Pincode Upload'));
        return $resultPage;
//        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}








