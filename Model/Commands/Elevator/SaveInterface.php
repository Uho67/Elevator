<?php
declare(strict_types=1);

namespace Mytest\Elevator\Model\Commands\Elevator;

use Mytest\Elevator\Api\Data\BaseElevatorInterface;

/**
 * A command which executes the elevator save operation.
 */
interface SaveInterface
{
    /**
     * @param BaseElevatorInterface $elevator
     *
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function execute(BaseElevatorInterface $elevator): int;
}
