<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-11-01
 * Time: 09:28
 */

namespace Mytest\Elevator\Controller\Adminhtml\BaseElevator;

use Mytest\Elevator\Controller\Adminhtml\AbstractElevator;

/**
 * Class Delete
 * @package Mytest\Elevator\Controller\Adminhtml\BaseElevator
 */
class Delete extends AbstractElevator
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if ($id) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the elevator.'));

                // go to grid
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());

                // go to grid
                return $this->redirectToGrid();
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find an elevator to delete.'));

        // go to grid
        return $this->redirectToGrid();
    }
}
