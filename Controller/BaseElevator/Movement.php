<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-24
 * Time: 12:39
 */

namespace Mytest\Elevator\Controller\BaseElevator;

/**
 * Class Movement
 * @package Mytest\Elevator\Controller\BaseElevator
 */
class Movement extends AbstractElevatorController
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
  public function execute()
  {
      $elevator = $this->_sessionManger->getMyElevator();
      $answer = array();
      $answer['speed']       = $elevator->getElevatorSpeed();
      $answer['arrived']     = 0;
      $answer['broken'] = 0;

      try {
          if ($elevator->getDirection() > 0) {
              $elevator->setCurrentFloor($elevator->getCurrentFloor()+1);
              if ($elevator->getCurrentFloor() == $elevator->getListUp()[0]) {
                  $answer['arrived'] = 1;
                  $list = $elevator->getListUp();
                  array_splice($list,0,1);
                  $elevator->setListUp($list);
              }
          } elseif ($elevator->getDirection() < 0) {
              $elevator->setCurrentFloor($elevator->getCurrentFloor()-1);
              if ($elevator->getCurrentFloor() == $elevator->getListBottom()[0]) {
                  $answer['arrived'] = 1;
                  $list = $elevator->getListBottom();
                  array_splice($list,0,1);
                  $elevator->setListBottom($list);
              }
          } else {
              $answer['arrived'] = 1;
          }
      } catch (\Magento\Framework\Exception\NotFoundException $e){
          $answer['broken'] = 1;
      }
      $answer['currentFloor'] = $elevator->getCurrentFloor();
      $this->_sessionManger->setMyElevator($elevator);
    return $this->jsonFactory->create()->setData($answer);
  }
}
