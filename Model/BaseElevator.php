<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 10:49
 */

namespace Mytest\Elevator\Model;

/**
 * Class BaseElevator
 * @package Mytest\Elevator\Model
 */
class BaseElevator extends \Magento\Framework\Model\AbstractModel implements \Mytest\Elevator\Api\Data\BaseElevatorInterface
{
    public function _construct()
    {
        $this->_init(\Mytest\Elevator\Model\ResourceModel\BaseElevator::class);
    }

    /**
     * @return mixed
     */
    public function getCurrentFloor()
    {
        return $this->getData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_CURRENT_FLOOR);
    }

    /**
     * @param $floor
     *
     * @return mixed|void
     */
    public function setCurrentFloor($floor)
    {
        $this->setData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_CURRENT_FLOOR, $floor);
    }

    /**
     * @return mixed
     */
    public function getMinFloor()
    {
        return $this->getData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_MIN_FLOOR);
    }

    /**
     * @param $floor
     *
     * @return mixed|void
     */
    public function setMinFloor($floor)
    {
        $this->setData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_MIN_FLOOR, $floor);
    }

    /**
     * @return mixed
     */
    public function getMaxFloor()
    {
        return $this->getData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_MAX_FLOOR);
    }

    /**
     * @param $floor
     *
     * @return mixed|void
     */
    public function setMaxFloor($floor)
    {
        $this->setData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_MAX_FLOOR, $floor);
    }

    /**
     * @return mixed
     */
    public function getIfBroken()
    {
        return $this->getData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_BROKEN);
    }

    /**
     * @param $yesno
     *
     * @return mixed|void
     */
    public function setIfBroken($yesno)
    {
        $this->setData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_BROKEN, $yesno);
    }

    /**
     * @return mixed
     */
    public function getElevatorSpeed()
    {
        return $this->getData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_SPEED);
    }

    /**
     * @param $speed
     *
     * @return mixed|void
     */
    public function setElevatorSpeed($speed)
    {
        $this->setData(\Mytest\Elevator\Api\Data\BaseElevatorInterface::FIELD_BROKEN, $speed);
    }
}
