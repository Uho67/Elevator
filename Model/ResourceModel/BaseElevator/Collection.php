<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 11:28
 */

namespace Mytest\Elevator\Model\ResourceModel\BaseElevator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Mytest\Elevator\Model\ResourceModel\BaseElevator
 */
class Collection extends AbstractCollection
{
    /** {@inheritdoc} */
    protected function _construct()
    {
        $this->_init(\Mytest\Elevator\Model\BaseElevator::class, \Mytest\Elevator\Model\ResourceModel\BaseElevator::class);
    }
}
