<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-24
 * Time: 16:22
 */

namespace Mytest\Elevator\Controller\BaseElevator;

/**
 * Class Free
 * @package Mytest\Elevator\Controller\BaseElevator
 */
class Free extends AbstractElevatorController
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $elevator = $this->_sessionManger->getMyElevator();
        $answer['go'] = 0;
        $answer['elevatorId'] = $elevator->getId();
        $elevator->setBusy(0);
        $this->_sessionManger->setMyElevator($elevator);
        $this->elevatorRepository->save($elevator);
        switch ($elevator->getDirection()) {
            case -1:
                if (!empty($elevator->getListBottom())) {
                    $answer['go'] = 1;
                    $answer['neededFloor'] = $elevator->getListBottom()[0];
                    return $this->jsonFactory->create()->setData($answer);
                } elseif (!empty($elevator->getListUp())) {
                    $answer['go'] = 1;
                    $answer['neededFloor'] = $elevator->getListUp()[0];
                    return $this->jsonFactory->create()->setData($answer);
                }break;
            case 1:
                if (!empty($elevator->getListUp())) {
                    $answer['go'] = 1;
                    $answer['neededFloor'] = $elevator->getListUp()[0];
                    return $this->jsonFactory->create()->setData($answer);
                } elseif (!empty($elevator->getListBottom())) {
                    $answer['go'] = 1;
                    $answer['neededFloor'] = $elevator->getListBottom()[0];
                    return $this->jsonFactory->create()->setData($answer);
                }break;
        }
        return $this->jsonFactory->create()->setData($answer);
    }
}
