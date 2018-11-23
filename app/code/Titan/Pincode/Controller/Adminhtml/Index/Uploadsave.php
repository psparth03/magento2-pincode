<?php
namespace Titan\Pincode\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Titan\Pincode\Model\ItemFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Uploadsave extends Action
{

    protected $_coreRegistry;

    protected $_resultPageFactory;

    protected $_itemFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ItemFactory $itemFactory,
        DateTime $date
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_itemFactory = $itemFactory;
        $this->date = $date;
    }

    public function execute()
    {
        $pincodeModel = $this->_itemFactory->create();

        if(isset($_FILES["upload"]["name"])){
            $path = $_FILES['upload']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            if($ext == "csv") {

                // if($_FILES['upload']['size'] > 100000)
                // {

                try{

                    $folder_pincode_path = BP.'/var/pincode';
                    $folder_inventory_export_path = BP.'/var/pincode/import';

                    if (!file_exists($folder_pincode_path)) {
                        mkdir($folder_pincode_path, 0775, true);
                    }

                    if (!file_exists($folder_inventory_export_path)) {
                        mkdir($folder_inventory_export_path, 0775, true);
                    }

                    $target_file = $folder_inventory_export_path . "/import_pincodes_".date("d-m-y").".csv";
                    $header = NULL;
                    $header_content = "pincode,city,state,country,status,cod";
                    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {

                        if (($handle = fopen($target_file, 'r')) !== FALSE)
                        {
                            $row = fgetcsv($handle);
                            $header = $row;
                            $pincoe_header =implode(",",$header);
                            $pincoe_header = strtolower($pincoe_header);
                            if($pincoe_header != $header_content){
                                $this->messageManager->addError("CSV header does not match. Eg Pincode,City,State,Country,Status,Cod");
                                $this->_redirect('*/*/upload');
                            }else{
                                $count = 1;
                                while (($row = fgetcsv($handle)) !== FALSE)
                                {
                                    if($count > 0)
                                    {
                                        $data['pincode'] = $row[0];
                                        $data['city'] = $row[1];
                                        $data['state'] = $row[2];
                                        $data['country'] = $row[3];
                                        $data['status'] = $row[4];
                                        $data['cod'] = $row[5];

                                        $pincodeModel->setData($data);

                                        $pincodeModel->save();
                                    }
                                    $count++;
                                }
                                fclose($handle);
                                $this->messageManager->addSuccess(__('The pincode has been saved.'));
                                $this->_redirect('*/*/index');
                            }

                        }

                    } else {
                        $this->messageManager->addError("Sorry, there was an error uploading your file.");
                        $this->_redirect('*/*/upload');
                    }

                }
                catch(\Exception $e){
                    $this->messageManager->addError(" Something went wrong.");
                    $this->_redirect('*/*/upload');
                }

                // }else{
                //     $this->messageManager->addError("Please Size is too large.");
                //     $this->_redirect('*/*/upload');
                // }

            }else{
                $this->messageManager->addError("Please upload CSV formate file.");
                $this->_redirect('*/*/upload');
            }

        }
        else{
            $this->messageManager->addError("Something went wrong please try later.");
            $this->_redirect('*/*/upload');
        }

    }
}
