<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 11:48
 */

namespace Mytest\Elevator\Api;

/**
 * Interface BaseElevatorRepositoryInterface
 * @package Mytest\Elevator\Api
 */
interface BaseElevatorRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteById($id);


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param Data\BaseElevatorInterface $baseElevator
     *
     * @return mixed
     */
    public function save(\Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator);

    /**
     * @param Data\BaseElevatorInterface $baseElevator
     *
     * @return mixed
     */
    public function delete(\Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator);
}
