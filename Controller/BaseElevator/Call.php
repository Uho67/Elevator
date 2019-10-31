<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-23
 * Time: 15:58
 */

namespace Mytest\Elevator\Controller\BaseElevator;

use Mytest\Elevator\Api\Data\BaseElevatorInterface;

/**
 * Class Call
 * @package Mytest\Elevator\Controller\BaseElevator
 */
class Call extends AbstractElevatorController
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
         $result = $this->jsonFactory->create();
         $id = $this->getRequest()->getParam('elevatorId');
         $elevator = $this->_sessionManger->getMyElevator();
         if (!$elevator) {
             $elevator = $this->elevatorRepository->getById($id);
         }
         $neededFloor = $this->getRequest()->getParam('neededFloor');
         if ($elevator->getIfBroken()) {
             return $result->setData(['broken'=>1]);
         } elseif (!$this->allowFloor($neededFloor, $elevator)) {
             return $result->setData(['allow'=>0]);
         }
         elseif ($elevator->getBusy()) {
             $this->floorToList($neededFloor,$elevator);
             return $result->setData(['busy'=>1]);
         }
         else{
             if ($elevator->getCurrentFloor() < $neededFloor) {
                 $elevator->setDirection(1);
             } elseif ($elevator->getCurrentFloor() > $neededFloor) {
                 $elevator->setDirection(-1);
             } else {
                 $elevator->setDirection(0);
             }
             $elevator->getNeededFloor($neededFloor);
             $elevator->setBusy(1);
             $this->floorToList($neededFloor,$elevator);
             return $this->_redirect($this::REDIRECT_ELEVATOR_MOVEMENT);
         }
    }

    /**
     * @param $floor
     * @param BaseElevatorInterface $elevator
     *
     * @return bool
     */
    private function allowFloor($floor ,BaseElevatorInterface $elevator)
    {
        if($floor<$elevator->getMinFloor() && $floor>$elevator->getMaxFloor()){
            return false;
        }
        return true;
    }

    /**
     * @param $floor
     * @param $elevator
     */
    private function floorToList($floor,$elevator)
    {
        if ($floor > $elevator->getCurrentFloor()) {
            if ($elevator->getListUp()) {
                $listFloor = $elevator->getListUp();
            }
            $listFloor[] = $floor;
            sort($listFloor);
            $elevator->setListUp(array_unique($listFloor));
        } elseif ($floor < $elevator->getCurrentFloor()) {
            if ($elevator->getListBottom()) {
                $listFloor = $elevator->getListBottom();
            }
            $listFloor[] = $floor;
            rsort($listFloor);
            $elevator->setListBottom(array_unique($listFloor));
        }
        $this->_sessionManger->setMyElevator($elevator);
    }
}
