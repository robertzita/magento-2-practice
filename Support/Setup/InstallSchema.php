<?php

namespace Iweb\Support\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
   ) {
        $installer = $setup;
        $installer->startSetup();
       
        $table = $installer->getConnection()->newTable($installer->getTable('iweb_support'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true
            ])
            ->addColumn('customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                 'nullable' => false
            ])
            ->addColumn('title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
                'nullable' => false
            ])
            ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
                'nullable' => false
            ])   
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ])
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ]);
        $installer->getConnection()->createTable($table);
       
        $tableReply = $installer->getConnection()->newTable($installer->getTable('iweb_support_reply'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true
            ])
            ->addColumn('support_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'nullable' => false
            ])
            ->addColumn('admin_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'optional' => true
            ])
            ->addColumn('comment', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
                'nullable' => false
            ])
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ]);
        $installer->getConnection()->createTable($tableReply);
       
        $installer->endSetup();
    }
}
