<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-11-01
 * Time: 09:46
 */

namespace Mytest\Elevator\Controller\Adminhtml\BaseElevator;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Mytest\Elevator\Api\BaseElevatorRepositoryInterface as Repository;
use Mytest\Elevator\Controller\Adminhtml\AbstractElevator;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Mytest\Elevator\Model\BaseElevatorFactory;
use Mytest\Elevator\Api\Data\BaseElevatorInterface;

/**
 * Class MassDelete
 * @package Mytest\Elevator\Controller\Adminhtml\BaseElevator
 */
class MassDelete extends AbstractElevator
{
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * MassDelete constructor.
     *
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param BaseElevatorFactory $baseElevatorFactory
     * @param PageFactory $pageFactory
     * @param SessionManagerInterface $sessionManager
     * @param Repository $repository
     * @param Context $context
     */
    public function __construct(SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory ,
                                BaseElevatorFactory $baseElevatorFactory,
                                PageFactory $pageFactory,
                                SessionManagerInterface $sessionManager,
                                Repository $repository,
                                Context $context)
    {
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        parent::__construct($baseElevatorFactory, $pageFactory, $sessionManager, $repository, $context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new \Magento\Framework\Exception\NotFoundException(__('Elements not found.'));
        }
        $ids = $this->getRequest()->getParam('selected');
        $excluded = $this->getRequest()->getParam('excluded');
        if($ids) {
            try {
                foreach ($ids as $id) {
                    $this->repository->deleteById($id);
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($ids)));
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go to grid
                return $this->redirectToGrid();
            }
        } elseif ($excluded) {
            $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
            $searchCriteria = $searchCriteriaBuilder->addFilter(BaseElevatorInterface::FIELD_ID, $excluded, 'nin')->create();
            $listElevators = $this->repository->getList($searchCriteria)->getItems();

            foreach ($listElevators as $elevator) {
                $this->repository->delete($elevator);
            }
        }
        return $this->redirectToGrid();
    }
}
