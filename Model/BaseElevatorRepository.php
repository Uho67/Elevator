<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-22
 * Time: 11:52
 */

namespace Mytest\Elevator\Model;

/**
 * Class BaseElevatorRepository
 * @package Mytest\Elevator\Model
 */
class BaseElevatorRepository implements \Mytest\Elevator\Api\BaseElevatorRepositoryInterface
{
    /**
     * @var BaseElevatorFactory
     */
    private $baseElevatorFactory;
    /**
     * @var ResourceModel\BaseElevator
     */
    private $resourceModel;
    /**
     * @var ResourceModel\BaseElevator\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Magento\Framework\Api\Search\SearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * BaseElevatorRepository constructor.
     *
     * @param BaseElevatorFactory $baseElevatorFactory
     * @param ResourceModel\BaseElevator $resourceModel
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param ResourceModel\BaseElevator\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\Search\SearchResultInterfaceFactory $searchResult
     */
    public function __construct(
        \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Mytest\Elevator\Model\BaseElevatorFactory $baseElevatorFactory,
        \Mytest\Elevator\Model\ResourceModel\BaseElevator $resourceModel,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Mytest\Elevator\Model\ResourceModel\BaseElevator\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\Search\SearchResultInterfaceFactory $searchResult
    ) {
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->resourceModel = $resourceModel;
        $this->baseElevatorFactory = $baseElevatorFactory;
        $this->searchResultFactory = $searchResult;
    }

    /**
     * @param $id
     *
     * @return mixed|BaseElevator
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $elevator = $this->baseElevatorFactory->create();
        $this->resourceModel->load($elevator, $id);
        if (!$elevator->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Elevator with id "%1" does not exist.', $id));
        }

        return $elevator;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param $id
     *
     * @return mixed|void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($id)
    {
        try {
            $this->delete($this->getById($id));
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
        }
    }

    /**
     * @param \Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator
     *
     * @return $this|mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator)
    {
        try {
            $this->resourceModel->delete($baseElevator);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }

        return $this;
    }

    /**
     * @param \Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Mytest\Elevator\Api\Data\BaseElevatorInterface $baseElevator)
    {
        try {
            $this->resourceModel->save($baseElevator);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $baseElevator;
    }
}
