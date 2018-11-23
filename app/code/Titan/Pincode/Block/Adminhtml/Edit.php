<?php

namespace Titan\Pincode\Block\Adminhtml;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    protected $_coreRegistry = null;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Titan_Pincode';
        $this->_controller = 'adminhtml';

        parent::_construct();

        if ($this->_isAllowedAction('Titan_Pincode::save')) {
            $this->buttonList->update('save', 'label', __('Save Pincode'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Titan_Pincode::grid_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Pincode'));
        } else {
            $this->buttonList->remove('delete');
        }

        if ($this->_coreRegistry->registry('pincode_grid')->getId()) {
            $this->buttonList->remove('reset');
        }
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('pincode_grid')->getId()) {
            return __("Edit Pincode '%1'", $this->escapeHtml($this->_coreRegistry->registry('pincode_grid')->getTitle()));
        } else {
            return __('New Pincode');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('pincode/index/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}