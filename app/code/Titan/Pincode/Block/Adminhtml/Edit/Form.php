<?php
namespace Titan\Pincode\Block\Adminhtml\Edit;
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_systemStore;
    protected $_status;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('pincode_form');
        $this->setTitle(__('Pincode Information'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('pincode_grid');

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('pincode_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'pincode',
            'text',
            ['name' => 'pincode', 'label' => __('Pincode'), 'title' => __('Pincode'), 'required' => true]
        );

        $fieldset->addField(
            'city',
            'text',
            ['name' => 'city', 'label' => __('City'), 'title' => __('City'), 'required' => true]
        );

        $fieldset->addField(
            'state',
            'text',
            ['name' => 'state', 'label' => __('State'), 'title' => __('State'), 'required' => true]
        );

        $fieldset->addField(
            'country',
            'text',
            ['name' => 'country', 'label' => __('Country'), 'title' => __('Country'), 'required' => true]
        );

        $fieldset->addField(
            'status',
            'text',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('1'), '0' => __('0')]
            ]
        );

        $fieldset->addField(
            'cod',
            'text',
            [
                'label' => __('COD'),
                'title' => __('COD'),
                'name' => 'cod',
                'required' => true,
                'options' => ['1' => __('1'), '0' => __('0')]
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}