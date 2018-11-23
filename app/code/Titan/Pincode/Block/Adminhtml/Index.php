<?php
namespace Titan\Pincode\Block\Adminhtml;

class Index extends \Magento\Backend\Block\Widget\Grid\Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'Titan_Pincode';
        $this->_controller = 'adminhtml_index';
        $this->_headerText = __('Pincode');
        $this->_addButtonLabel = __('Create New Pincode');
        parent::_construct();
    }
}
