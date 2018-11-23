<?php
namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Titan\Pincode\Model\ItemFactory;

class Exportcsv extends Action
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
        $pincodesIds = $this->getRequest()->getParam('internal_pincode');
        $ids = explode(",",$pincodesIds);
        $itemModel = $this->_itemFactory->create();
        $filename = "export_pincode_".date("d-m-y").".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $output = fopen('php://output', 'w');

        $header = array(
            'pincode',
            'city',
            'state',
            'country',
            'status',
            'cod'
        );

        fputcsv($output, $header);

        $column = array(
            'pincode'=>'',
            'city'=>'',
            'state'=>'',
            'country'=>'',
            'status'=>'',
            'cod'=>'',
        );

        foreach ($ids as $pincodeId) {
            try {
                //echo $pincodeId;
                /*echo $pincodeId;*/
                /** @var $itemModel \Titan\Pincode\Model\Item */

                $pindata = $itemModel->load($pincodeId);
                $pindata_pincode = $pindata->getData('pincode');
                $pindata_city = $pindata->getData('city');
                $pindata_state = $pindata->getData('state');
                $pindata_country = $pindata->getData('country');
                $pindata_status = $pindata->getData('status');
                $pindata_cod = $pindata->getData('cod');

                $column['pincode'] = $pindata_pincode;
                $column['city'] = $pindata_city;
                $column['state'] = $pindata_state;
                $column['country'] = $pindata_country;
                $column['status'] = $pindata_status;
                $column['cod'] = $pindata_cod;
                //var_dump($column);
                fputcsv($output, $column);


            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        /*$this->_view->loadLayout();
        $fileName = 'sample_data.csv';
        $content = $this->_view->getLayout()->getChildBlock('sample.grid', 'grid.export');

        return $this->_pincodeFactory->create(
            $fileName,
            $content->getCsvFile($fileName),
            DirectoryList::VAR_DIR
        );*/
    }
}
