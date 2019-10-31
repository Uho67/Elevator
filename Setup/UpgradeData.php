<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-23
 * Time: 16:34
 */

namespace Mytest\Elevator\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Class UpgradeData
 * @package Mytest\Elevator\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * UpgradeData constructor.
     *
     * @param PageFactory $pageFactory
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(PageFactory $pageFactory, EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->pageFactory     = $pageFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1','<')) {
            $page = $this->pageFactory->create();
            $page->setTitle('My static Block')
                ->setIdentifier('my-static-block')
                ->setIsActive(true)
                ->setPageLayout('3column')
                ->setStores(array(0))
                ->setContent('I am first static bloc')
                ->save();
        }
        if (version_compare($context->getVersion(), '1.0.8','<')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sample_attribute',
                [
                    'type' => 'int',
                    'backend' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'frontend' => '',
                    'label' => 'Sample Atrribute',
                    'input' => 'boolean',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '1',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.11','<')) {

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sample_attribute_country',
                [
                    'type' => 'varchar',
                    'backend' => \Mytest\Elevator\Model\Attribute\Backend\MyAttributClosedCountry::class,
                    'source' => \Magento\Customer\Model\ResourceModel\Address\Attribute\Source\Country::class,
                    'frontend' => '',
                    'label' => 'Sample Atrribute',
                    'input' => 'multiselect',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '1',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );
        }
        $setup->endSetup();
    }
}
