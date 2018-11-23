<?php
namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Titan_Pincode::save');
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Titan_Pincode::pincode')
            ->addBreadcrumb(__('Pincode'), __('Pincode'))
            ->addBreadcrumb(__('Pincode Edit/Add'), __('Pincode Edit/Add'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magebuzz\Staff\Model\Grid $model */
        $model = $this->_objectManager->create('Titan\Pincode\Model\Item');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Pincode no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('pincode_grid', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Grid') : __('New Grid'),
            $id ? __('Edit Grid') : __('New Grid')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Pincode Grid'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Pincode'));

        return $resultPage;
    }
}