<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-28
 * Time: 14:25
 */

namespace Mytest\Elevator\Ui\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class Actions
 * @package Mytest\Elevator\Ui\Listing
 */
class Actions extends Column
{
    /**
     *
     */
    const URL_EDIT = 'elevator/baseelevator/edit';

    /**
     *
     */
    const IDENTIFIRE = 'elevator_id';

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Actions constructor.
     *
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(UrlInterface $urlBuilder,
                                ContextInterface $context,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [], array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $name = $this->getName();
        if(isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if(isset($item['elevator_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this::URL_EDIT, ['id' => $item[$this::IDENTIFIRE]]),
                        'label' => __('Edit')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
