<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-31
 * Time: 14:24
 */

namespace Mytest\Elevator\Block\Adminhtml\Elevator\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /** {@inheritdoc} */
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
