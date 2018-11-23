<?php
namespace Titan\Pincode\Controller\Index;

use Titan\Pincode\Model\ItemFactory;
use Titan\Pincode\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class Zipcode extends \Magento\Framework\App\Action\Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
    /**      * @param \Magento\Framework\App\Action\Context $context      */

    protected $_request;
    protected $customerSessionFactory;
    protected $_coreSession;
    protected $sessionFactory;
    protected $logger;
    protected $objectManager;
    protected $_curl;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Framework\App\RequestInterface $request,
                                \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                                \Magento\Customer\Model\SessionFactory $customerSessionFactory,
                                \Magento\Framework\Session\SessionManagerInterface $coreSession,
                                \Psr\Log\LoggerInterface $logger,
                                \Magento\Framework\ObjectManagerInterface $objectManager,
                                \Magento\Framework\HTTP\Client\Curl $curl,
//                                \MagePal\GeoIp\Service\GeoIpService $geoIpService,
                                CollectionFactory $pincodeFactory
    ) {
        $this->_request = $request;
        $this->pincodeFactory = $pincodeFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->_coreSession = $coreSession;
        $this->logger = $logger;
        $this->_curl = $curl;
        $this->objectManager = $objectManager;
//        $this->geoIpService = $geoIpService;
        parent::__construct($context);
    }
    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
//        $countryCode = $this->geoIpService->getCountry();
//        echo $countryCode;exit;
        $resultData = $this->pincode();
        if ($resultData) {
            $suc_msg = [
                'status' => 'success',
                'response' => $resultData[0],
            ];
        } else {
            $suc_msg = [
                'status' => 'fail',
                'message' => "Something went wrong please try later."
            ];
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($suc_msg);
        return $resultJson;
    }

    public function pincode() {
        $post_data = $this->_request->getParams('pin_number');
        $pin_only = $post_data['pin_number'];
        $this->setValue($pin_only);
        $pincode_object = $this->pincodeFactory->create();
        $pins = $pincode_object->addFieldToFilter('pincode',$post_data);
        return $pins->getData();
    }

    public function setValue($new_pin){
        $this->_coreSession->start();
        return $this->_coreSession->setMessage($new_pin);
    }

//    public function getCountryName() {
//        $visitorIp = $this->getVisitorIp();
//        $url = "http://local.magento-two-three.in/111.119.208.155? access_key = e123b72377d7660458b5fc5b628d158e".$visitorIp;
//        $this->_curl->get($url);
//        $response = json_decode($this->_curl->getBody(), true);
//        $countryName = $response['country_name'];
//        $stateName = $response['region_name'];
//        echo $stateName;exit;
//        return $stateName;
//    }
//
//    function getVisitorIp() {
//        $remoteAddress = $this->objectManager->create('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
//        return $remoteAddress->getRemoteAddress();
//    }


}