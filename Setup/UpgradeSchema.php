<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Cap\CustomerRequest\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    /**
     * @inheritDoc
     */
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        /**
         * 0.0.2
         */
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $table = $installer->getTable('cap_customer_request_stock');
            $installer->getConnection()->addColumn(
                $table,
                'image_path',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 128,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Product Image Path'
                ]
            );

            $fullTextIndex = ['product_sku','product_name', 'customer_name', 'customer_email'];
            $installer->getConnection()->addIndex(
                $table,
                $installer->getIdxName(
                    $table,
                    $fullTextIndex,
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                $fullTextIndex,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            $installer->endSetup();
        }

        /**
         * 0.0.3
         */
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $table = $installer->getTable('cap_customer_request_rma');
            $installer->getConnection()->addColumn(
                $table,
                'status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'length' => 6,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Request Status'
                ]
            );

            $fullTextIndex = ['product_sku','product_name', 'customer_name', 'customer_email'];
            $installer->getConnection()->addIndex(
                $table,
                $installer->getIdxName(
                    $table,
                    $fullTextIndex,
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                $fullTextIndex,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            $installer->endSetup();
        }
    }
}
