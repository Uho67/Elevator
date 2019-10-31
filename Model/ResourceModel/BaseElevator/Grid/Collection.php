<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 14:25
 */

namespace Mytest\Elevator\Model\ResourceModel\BaseElevator\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Magento\Framework\Api\SearchCriteriaInterface;

use Mytest\Elevator\Model\ResourceModel\BaseElevator as ResourceModel;
use Mytest\Elevator\Model\ResourceModel\BaseElevator\Collection as ElevatorCollection;

/**
 * Class Collection
 * @package Mytest\Elevator\Model\ResourceModel\BaseElevator\Grid
 */
class Collection extends ElevatorCollection implements SearchResultInterface
{
    /** @var AggregationInterface */
    protected $aggregations;
    /** @var SearchCriteriaInterface */
    protected $searchCriteria;
    /** {@inheritdoc} */
    public function _construct()
    {
        $this->_init(Document::class, ResourceModel::class);
    }
    /** {@inheritdoc} */
    public function getAggregations()
    {
        return $this->aggregations;
    }
    /** {@inheritdoc} */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
    /** {@inheritdoc} */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }
    /** {@inheritdoc} */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }
    /** {@inheritdoc} */
    public function getTotalCount()
    {
        return $this->getSize();
    }
    /** {@inheritdoc} */
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    /** {@inheritdoc} */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
