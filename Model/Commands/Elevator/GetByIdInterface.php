<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-11-28
 * Time: 13:28
 */

namespace Mytest\Elevator\Model\Commands\Elevator;

    /**
     * A command represents the get elevator by using elevator id as a filter parameter.
     */
interface GetByIdInterface
{
    /**
     * Get elevator by id
     *
     * @param int $elevatorId
     *
     * @return \Mytest\Elevator\Api\Data\BaseElevatorInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\IntegrationException
     */
    public function execute(int $elevatorId): \Mytest\Elevator\Api\Data\BaseElevatorInterface;
}
//example /rest/V1/elevator/getone/22
//  curl -X GET "http://devbox.vaimo.test/newmagento/rest/all/V1/elevator/getone/22" -H "accept: application/json"
