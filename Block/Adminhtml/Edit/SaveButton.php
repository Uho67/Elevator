<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-28
 * Time: 16:06
 */

namespace Mytest\Elevator\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\Session\SessionManagerInterface;

/**
 * Class SaveButton
 * @package Mytest\Elevator\Block\Adminhtml\Edit
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;
    /**
     * @var Context
     */
    private $context;

    /**
     * SaveButton constructor.
     *
     * @param Context $context
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(Context $context,
                                SessionManagerInterface $sessionManager)
    {
        $this->context         =  $context;
        $this->sessionManager  =  $sessionManager;
    }

    /**
     * @return |null
     */
    public function getElevatorId()
    {
        try {
            return $this->sessionManager->getCurrentElevatorModel();
        }catch (\Magento\Framework\Exception\NoSuchEntityException $e){}
        return null;
    }

    /**
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Elevator'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
