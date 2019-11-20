<?php

 namespace Iweb\Note\Setup;
 
 class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
 {
     public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
     ) {
        $installer = $setup;
        
        $installer->startSetup();
        
        $quoteTable = $installer->getTable('quote');
        
        $columns = [
            'delivery_note' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'delivery_note'
            ],
        ];
        
        $connection = $installer->getConnection();
        foreach($columns as $name => $definition) {
            $connection->addColumn($quoteTable, $name, $definition);
        }
        
        $salesOrderTable = $installer->getTable('sales_order');
        
        $salesColumns = [
            'delivery_note' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'delivery_note'
            ],
        ];
        
        foreach ($salesColumns as $columnName => $definition) {
            $connection->addColumn($salesOrderTable, $columnName, $definition);
        }
        
        $installer->endSetup();
     }
 }
 