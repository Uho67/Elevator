<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-23
 * Time: 11:40
 */

namespace Mytest\Elevator\Block\BaseElevator;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mytest\Elevator\Model\BaseElevatorFactory;
use Mytest\Elevator\Api\BaseElevatorRepositoryInterface;

/**
 * Class Index
 * @package Mytest\Elevator\Block\BaseElevator
 */
class Index extends Template
{
    /**
     * @var BaseElevatorFactory
     */
    private $elevatorFactory;
    /**
     * @var BaseElevatorRepositoryInterface
     */
    private $elevatorRepository;

    /**
     * Index constructor.
     *
     * @param BaseElevatorFactory $elevatorFactory
     * @param BaseElevatorRepositoryInterface $baseElevatorRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(BaseElevatorFactory $elevatorFactory,
                                BaseElevatorRepositoryInterface $baseElevatorRepository,
                                Context $context, array $data = []
    ) {
        $this->elevatorFactory    = $elevatorFactory;
        $this->elevatorRepository = $baseElevatorRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getCurrentElevator()
    {
        return $this->elevatorRepository->getById($this->getRequest()->getParam('id'));
    }
}
