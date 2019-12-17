<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 10:56
 */

namespace Mytest\Elevator\Model\ResourceModel;

use Mytest\Elevator\Api\Data\BaseElevatorInterface;

/**
 * Class BaseElevator
 * @package Mytest\Elevator\Model\ResourceModel
 */
class BaseElevator extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /** {@inheritdoc} */
    protected function _construct()
    {
        $this->_init(BaseElevatorInterface::TABLE_NAME, BaseElevatorInterface::FIELD_ID);
    }
}
