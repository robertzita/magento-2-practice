<?php

namespace Iweb\Support\Setup;
 
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $setup->startSetup();
         
        if(version_compare($context->getVersion(), '1.0.1') < 0) {
            $tableName = $setup->getTable('iweb_support');
        }
         
        $columns = [
            'solved' => [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment'  => 'Solved'
            ]
        ];
         
        foreach($columns as $columnName => $definition) {
            $setup->getConnection()->addColumn($tableName, $columnName, $definition);
        }
         
        $setup->endSetup();
    }
}