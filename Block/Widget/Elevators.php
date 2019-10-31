<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 16:50
 */

namespace Mytest\Elevator\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Mytest\Elevator\Model\ResourceModel\BaseElevator\CollectionFactory as ElevatorCollectionFactory;

/**
 * Class Elevators
 * @package Mytest\Elevator\Block\Widget
 */
class Elevators extends Template implements BlockInterface
{
    /**
     *
     */
    const LINK_GO_TO_ELEVATOR_PAGE = '/newmagento/elevator/house/index/id/';
    /**
     * @var string
     */
    protected $_template = "widget/elevatorsListButtons.phtml";
    /**
     * @var ElevatorCollectionFactory
     */
    private $elevatorCollectionFactory;

    /**
     * Elevators constructor.
     *
     * @param ElevatorCollectionFactory $collection
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(ElevatorCollectionFactory $collection, Template\Context $context, array $data = [])
    {
        $this->elevatorCollectionFactory = $collection;
        parent::__construct($context, $data);
    }

    /**
     * @return \Mytest\Elevator\Model\ResourceModel\BaseElevator\Collection
     */
    public function getListElevators()
    {
        $collection = $this->elevatorCollectionFactory->create();
        $collection->load();
        return $collection;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this::LINK_GO_TO_ELEVATOR_PAGE;
    }
}
