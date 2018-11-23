<?php
namespace Titan\Pincode\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $table = $setup->getConnection()->newTable(
            $setup->getTable('pincode')
        )->addColumn(
            'id',
            Table:: TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'pincode',
            Table::TYPE_TEXT,
            '10',
            [],
            'PINCODE'
        )->addColumn(
            'city',
            Table::TYPE_TEXT,
            '75',
            [],
            'City'
        )->addColumn(
            'state',
            Table::TYPE_TEXT,
            '75',
            [],
            'State'
        )->addColumn(
            'country',
            Table::TYPE_TEXT,
            '75',
            [],
            'Country'
        )->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            [],
            'Pincode Status'
        )->addColumn(
            'cod',
            Table::TYPE_BOOLEAN,
            null,
            [],
            'COD status'
        )->setComment(
            'Pincode Table'
        );
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}