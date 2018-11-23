<?php
namespace Titan\Pincode\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface {
    public function install( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {
        $setup->startSetup();
        $setup->getConnection()->insert(
          $setup->getTable('pincode'),
          [
              'pincode' => 400092,
              'city' => 'Mumbai',
              'state' => 'Maharashtra',
              'country' => 'India',
              'status' => 1,
              'COD' => 1
          ]
        );

        $setup->endSetup();
    }
}