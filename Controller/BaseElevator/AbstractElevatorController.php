<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-24
 * Time: 13:45
 */

namespace Mytest\Elevator\Controller\BaseElevator;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Registry;
use Mytest\Elevator\Api\BaseElevatorRepositoryInterface as ElevatorRepository;

/**
 * Class AbstractElevatorController
 * @package Mytest\Elevator\Controller\BaseElevator
 */
abstract class AbstractElevatorController extends Action
{
    /**
     *
     */
    const REDIRECT_ELEVATOR_MOVEMENT = '*/baseelevator/movement';
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var ElevatorRepository
     */
    protected $elevatorRepository;
    /**
     * @var SessionManagerInterface
     */
    protected $_sessionManger;
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * AbstractElevatorController constructor.
     *
     * @param SessionManagerInterface $sessionManager
     * @param Registry $registry
     * @param ElevatorRepository $elevatorRepository
     * @param JsonFactory $jsonFactory
     * @param Context $context
     */
    public function __construct(SessionManagerInterface $sessionManager,
                                Registry $registry,
                                ElevatorRepository $elevatorRepository,
                                JsonFactory $jsonFactory,
                                Context $context
    ) {
        $this->_sessionManger      = $sessionManager;
        $this->_registry           = $registry;
        $this->elevatorRepository = $elevatorRepository;
        $this->jsonFactory        = $jsonFactory;
        parent::__construct($context);
    }
}
