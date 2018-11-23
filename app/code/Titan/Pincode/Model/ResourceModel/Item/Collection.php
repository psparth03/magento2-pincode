<?php

namespace Titan\Pincode\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
//use Titan\Pincode\Model\Item;
//use Titan\Pincode\Model\ResourceModel\Items;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Titan\Pincode\Model\Item::class, \Titan\Pincode\Model\ResourceModel\Item::class);
    }
}



