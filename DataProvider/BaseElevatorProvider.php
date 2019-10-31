<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-28
 * Time: 14:15
 */

namespace Mytest\Elevator\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Session\SessionManagerInterface;
use Mytest\Elevator\Model\ResourceModel\BaseElevator\CollectionFactory;

/**
 * Class BaseElevatorProvider
 * @package Mytest\Elevator\DataProvider
 */
class BaseElevatorProvider extends AbstractDataProvider
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;


    public function __construct(CollectionFactory $collectionFactory,
                                SessionManagerInterface $sessionManager,
                                $name,
                                $primaryFieldName,
                                $requestFieldName,
                                array $meta = [], array
                                $data = [])
    {
        $this->collection      =  $collectionFactory->create();
        $this->sessionManager  =  $sessionManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $model = $this->sessionManager->getCurrentElevatorModel();
        if($model!=null) {
          return [$model->getId()=> $model->getData()];
        } else return [];
    }
}
