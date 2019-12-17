<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-31
 * Time: 13:54
 */

namespace Mytest\Elevator\Controller\Adminhtml\BaseElevator;

use Mytest\Elevator\Api\Data\BaseElevatorInterface as ElevatorInterface;
use Mytest\Elevator\Controller\Adminhtml\AbstractElevator;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Mytest\Elevator\Controller\Adminhtml\BaseElevator
 */
class Save extends AbstractElevator
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $isPost = $this->getRequest()->isPost();
        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParam('elevator');
            if (empty($formData)) {
                $formData = $this->getRequest()->getParams();
            }
            if (!empty($formData[ElevatorInterface::FIELD_ID])) {
                $id = $formData[ElevatorInterface::FIELD_ID];
                $model = $this->repository->getById($id);
            } else {
                unset($formData[ElevatorInterface::FIELD_ID]);
            }
            $model->setData($formData);
            $validation = $this->validation($model);
            if (array_shift($validation)) {
                foreach ($validation as $message) {
                    $this->messageManager->addErrorMessage(__($message));
                }
                unset($formData[ElevatorInterface::FIELD_ID]);
                $this->_getSession()->setFormData($formData);

                return $this->_redirect('*/*/edit');
            }
            try {
                $model = $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Elevator has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', [
                        'id' => $model->getId(),
                        '_current' => true
                    ]);
                }
                $this->_getSession()->setFormData(null);

                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Elevator doesn\'t save'));
            }
            $this->_getSession()->setFormData($formData);

            return (!empty($model->getId())) ?
                $this->_redirect('*/*/edit', ['id' => $model->getId()])
                : $this->_redirect('*/*/edit');
        }

        return $this->doRefererRedirect();
    }

    /**
     * @param ElevatorInterface $model
     *
     * @return array
     */
    private function validation(ElevatorInterface $model)
    {
        if ($model->getMaxFloor() <= $model->getMinFloor()) {
            $answer[] = 'Max floor can not be equal or less than Min';
        }
        if ($model->getCurrentFloor() < $model->getMinFloor() || $model->getCurrentFloor() > $model->getMaxFloor()) {
            $answer[] = 'Chose current floor';
        }
        if (isset($answer)) {
            array_unshift($answer, true);
        } else {
            $answer[] = false;
        }

        return $answer;
    }
}
