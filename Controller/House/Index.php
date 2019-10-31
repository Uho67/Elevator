<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 15:49
 */

namespace Mytest\Elevator\Controller\House;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Session\SessionManagerInterface;

/**
 * Class Index
 * @package Mytest\Elevator\Controller\House
 */
class Index extends Action
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(Context $context, SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->sessionManager->setMyElevator(NULL);
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
