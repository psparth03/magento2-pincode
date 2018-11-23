<?php
namespace Titan\Pincode\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;

class Zipcode extends \Magento\Framework\View\Element\Template
{
    protected $_coreSession;

    public function __construct(Context $context,
                                Session $customerSession,
                                \Magento\Framework\Session\SessionManagerInterface $coreSession
    ) {
        $this->_session = $customerSession;
        $this->_coreSession = $coreSession;
        parent::__construct($context);
    }

    public function getCustomerSession()
    {
        return $this->_session;
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getValue(){
        $this->_coreSession->start();
        return $this->_coreSession->getMessage();
    }

}