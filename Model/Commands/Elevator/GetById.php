<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-11-28
 * Time: 17:21
 */

namespace Mytest\Elevator\Model\Commands\Elevator;

use Mytest\Elevator\Model\BaseElevatorFactory;
use Magento\Framework\Exception\IntegrationException;
use Magento\Framework\Exception\NoSuchEntityException;
use \Mytest\Elevator\Api\Data\BaseElevatorInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;

/**
 * Class GetById
 * @package Mytest\Elevator\Model\Commands\Elevator
 */
class GetById implements GetByIdInterface
{
    /**
     * table name for elevator model
     */
    const TABLE_ELEVATOR = 'mytest_elevator';
    /**
     * primary field for elevator's table
     */
    const FIELD_ID = 'elevator_id';
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resourceConnection;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var \Mytest\Elevator\Model\BaseElevatorFactory
     */
    private $elevatorFactory;

    /**
     * GetById constructor.
     *
     * @param \Mytest\Elevator\Model\BaseElevatorFactory $elevatorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     */
    public function __construct(
        BaseElevatorFactory $elevatorFactory,
        LoggerInterface $logger,
        ResourceConnection $resourceConnection
    ) {
        $this->elevatorFactory = $elevatorFactory;
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param int $elevatorId
     *
     * @return \Mytest\Elevator\Api\Data\BaseElevatorInterface
     * @throws \Magento\Framework\Exception\IntegrationException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(int $elevatorId): BaseElevatorInterface
    {
        try {
            $elevatorTable = $this->resourceConnection->getTableName(self::TABLE_ELEVATOR);
            $connection = $this->resourceConnection->getConnection();
            $select = $connection->select()
                ->from($elevatorTable)
                ->where(self::FIELD_ID . ' = ?', $elevatorId);
            $elevatorData = $connection->query($select)->fetch();
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __(
                'En error occurred during get elevator data by elevator_id %id: %error',
                [
                    'id' => $elevatorId,
                    'error' => $exception->getMessage()
                ]
            );
            throw new IntegrationException($message, $exception);
        }
        if (empty($elevatorData)) {
            $message = __('There is no such elevator with id %id', ['id' => $elevatorId]);
            throw new NoSuchEntityException($message);
        }
        try {
            return $this->elevatorFactory->create(['data' => $elevatorData]);
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __(
                'En error occurred during initialize elevator with id %id: %error',
                [
                    'id' => $elevatorId,
                    'error' => $exception->getMessage()
                ]
            );
            throw new IntegrationException($message, $exception);
        }
    }
}
