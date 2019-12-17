<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-31
 * Time: 18:07
 */

namespace Mytest\Elevator\Controller\Adminhtml\BaseElevator;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Mytest\Elevator\Api\BaseElevatorRepositoryInterface as Repository;
use Mytest\Elevator\Controller\Adminhtml\AbstractElevator;
use Mytest\Elevator\Api\Data\BaseElevatorInterface;
use Mytest\Elevator\Model\BaseElevatorFactory;

/**
 * Class InlineEdit
 * @package Mytest\Elevator\Controller\Adminhtml\BaseElevator
 */
class InlineEdit extends AbstractElevator
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * InlineEdit constructor.
     *
     * @param JsonFactory $jsonFactory
     * @param BaseElevatorFactory $baseElevatorFactory
     * @param PageFactory $pageFactory
     * @param SessionManagerInterface $sessionManager
     * @param Repository $repository
     * @param Context $context
     */
    public function __construct(JsonFactory $jsonFactory,
                                BaseElevatorFactory $baseElevatorFactory,
                                PageFactory $pageFactory,
                                SessionManagerInterface $sessionManager,
                                Repository $repository,
                                Context $context)
    {
        $this->jsonFactory = $jsonFactory;
        parent::__construct($baseElevatorFactory, $pageFactory, $sessionManager, $repository, $context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $elevatorId) {
                    $elevator = $this->repository->getById($elevatorId);
                    try {
                        $elevator->setData(array_merge($elevator->getData(), $postItems[$elevatorId]));
                        $this->repository->save($elevator);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBlockId(
                            $elevator,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * @param BaseElevatorInterface $elevator
     * @param $errorText
     *
     * @return string
     */
    protected function getErrorWithBlockId(BaseElevatorInterface $elevator, $errorText)
    {
        return '[Elevator ID: ' . $elevator->getId() . '] ' . $errorText;
    }
}
