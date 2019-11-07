<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-21
 * Time: 14:46
 */

namespace Mytest\Elevator\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Mytest\Elevator\Api\Data\BaseElevatorInterface;

/**
 * Class InstallSchema
 * @package Mytest\Elevator\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     *
     */
    const TABLE_BLOCKED_FLOOR = 'table_blocked_floor';
    /**
     *
     */
    const FIELD_FLOOR = 'blocked_floor';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createElevatorTable($setup);
        $this->createBlockedFloor($setup);
    }

    /**
     * @param SchemaSetupInterface $setup
     *
     * @throws \Zend_Db_Exception
     */
    private function createElevatorTable(SchemaSetupInterface $setup)
    {
        $setup->startSetup();
        $tableElevator = $setup->getConnection()->newTable(
            $setup->getTable( BaseElevatorInterface::TABLE_NAME)
        )->addColumn(
            BaseElevatorInterface::FIELD_ID,
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned'=> true],
            'Elevator ID'
        )->addColumn(
            BaseElevatorInterface::FIELD_CURRENT_FLOOR,
            Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> false],
            'Current floor'
        )->addColumn(
            BaseElevatorInterface::FIELD_MAX_FLOOR,
            Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> false],
            'Max floor'
        )->addColumn(
            BaseElevatorInterface::FIELD_MIN_FLOOR,
            Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> false],
            'Min floor'
        )->addColumn(
            BaseElevatorInterface::FIELD_BROKEN,
            Table::TYPE_BOOLEAN,
            255,
            ['nullable' => false],
            'Broken or not'
        )->addColumn(
            BaseElevatorInterface::FIELD_SPEED,
            Table::TYPE_FLOAT,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> true],
            'speed from elevator'
        )->setComment(
            'elevator table'
        );
        $setup->getConnection()->createTable($tableElevator);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     *
     * @throws \Zend_Db_Exception
     */
    private function createBlockedFloor($setup)
    {
        $setup->startSetup();
        $tableBunch = $setup->getConnection()->newTable(
            $setup->getTable($this::TABLE_BLOCKED_FLOOR)
        )->addColumn(
            BaseElevatorInterface::FIELD_ID,
            Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> true],
            'Elevator ID'
        )->addColumn(
            $this::FIELD_FLOOR,
            Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'nullable' => false, 'unsigned'=> true],
            'Blocked floor'
        )->addForeignKey( // Add foreign key for table entity
            $setup->getFkName(
                $this::TABLE_BLOCKED_FLOOR, // New table
                BaseElevatorInterface::FIELD_ID, // Column in New Table
                BaseElevatorInterface::TABLE_NAME, // Reference Table
                BaseElevatorInterface::FIELD_ID// Column in Reference table
            ),
            $this::FIELD_FLOOR, // New table column
            $setup->getTable(BaseElevatorInterface::TABLE_NAME), // Reference Table
            BaseElevatorInterface::FIELD_ID, // Reference Table Column
            // When the parent is deleted, delete the row with foreign key
            Table::ACTION_CASCADE
        )->setComment(
            'table bunch block floor'
        );
        $setup->getConnection()->createTable($tableBunch);
        $setup->endSetup();
    }
}
