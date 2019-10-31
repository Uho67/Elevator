<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-28
 * Time: 13:49
 */

namespace Mytest\Elevator\Controller\Adminhtml\BaseElevator;
use Mytest\Elevator\Controller\Adminhtml\AbstractElevator;

/**
 * Class Edit
 * @package Mytest\Elevator\Controller\Adminhtml\BaseElevator
 */
class Edit extends AbstractElevator
{
    /**
     *
     */
    const TITLE = 'Elevator Edit';

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if($id == null){
            return parent::execute();
        }
        if (!empty($id)) {
            try {
                $model = $this->repository->getById($id);
                $this->sessionManager->setCurrentElevatorModel($model);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->logger->error($exception->getMessage());
                $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
                return $this->redirectToGrid();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
            $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
            return $this->redirectToGrid();
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->sessionManager->setCurrentElevatorModel($model);
        return parent::execute();
    }
}
