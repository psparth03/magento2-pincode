<?php
 namespace Titan\Pincode\Model;

 use Magento\Framework\Model\AbstractModel;

 class Item extends AbstractModel
 {
     protected function _construct()
     {
         $this->_init(\Titan\Pincode\Model\ResourceModel\Item::class);
     }
 }






