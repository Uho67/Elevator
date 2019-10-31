<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-21
 * Time: 14:37
 */

namespace Mytest\Elevator\Api\Data;

/**
 * Interface BaseElevatorInterface
 * @package Mytest\Elevator\Api\Data
 */
interface BaseElevatorInterface
{
    const TABLE_NAME          = 'mytest_elevator';
    const FIELD_ID            = 'elevator_id';
    const FIELD_CURRENT_FLOOR = 'current_floor';
    const FIELD_MAX_FLOOR     = 'max_floor';
    const FIELD_MIN_FLOOR     = 'min_floor';
    const FIELD_BROKEN        = 'if_broken';
    const FIELD_SPEED         = 'elevator_speed';
    const REGISTRY_KEY_ELEVATOR   = 'mytest_elevator_current_elevator';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getCurrentFloor();

    /**
     * @param $floor
     *
     * @return mixed
     */
    public function setCurrentFloor($floor);

    /**
     * @return mixed
     */
    public function getMaxFloor();

    /**
     * @param $floor
     *
     * @return mixed
     */
    public function setMaxFloor($floor);

    /**
     * @return mixed
     */
    public function getMinFloor();

    /**
     * @param $floor
     *
     * @return mixed
     */
    public function setMinFloor($floor);

    /**
     * @param $yesno
     *
     * @return mixed
     */
    public function setIfBroken($yesno);

    /**
     * @return mixed
     */
    public function getIfBroken();

    /**
     * @return mixed
     */
    public function getElevatorSpeed();

    /**
     * @param $speed
     *
     * @return mixed
     */
    public function setElevatorSpeed($speed);
}
