<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-11-28
 * Time: 18:37
 */

namespace Mytest\Elevator\Model\Commands\Elevator;

use Mytest\Elevator\Api\Data\BaseElevatorInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class Save
 * @package Mytest\Elevator\Model\Commands\Elevator
 */
class Save implements SaveInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Save constructor.
     *
     * @param LoggerInterface $logger
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        LoggerInterface $logger,
        ResourceConnection $resourceConnection
    ) {
        $this->logger = $logger;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param BaseElevatorInterface $elevator
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(BaseElevatorInterface $elevator): int
    {
        try {
            /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
            $connection = $this->resourceConnection->getConnection();
            $tableName = $this->resourceConnection->getTableName(BaseElevatorInterface::TABLE_NAME);
            $data = $elevator->getData('');
            $connection->insertOnDuplicate($tableName, $data);
            return (int)$connection->lastInsertId($tableName);
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            $message = __('An error occurred during media asset save: %1', $exception->getMessage());
            throw new CouldNotSaveException($message, $exception);
        }
    }
}
//curl -X POST "http://devbox.vaimo.test/newmagento/rest/all/V1/elevator" -H "accept: application/json" -H "Content-Type: appcation/json" -H "Authorization: Bearer 29fe9c14mg7m8wpdh9mgsowf2bob104e" -d "{ \"elevator\": { \"current_floor\": \"10\", \"max_floor\": \"10\", \"min_floor\": \"0\", \"if_broken\": \"0\", \"elevator_speed\": \"1\"}}"
