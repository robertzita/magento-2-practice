<?php

namespace Iweb\Note\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $setup->startSetup();
        
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $tableName = $setup->getTable('sales_order_grid');
            
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                $columns = [
                    'delivery_note' => [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment'  => 'delivery note'
                    ]
                ];
                
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }
        
        $setup->endSetup();
    }
}
