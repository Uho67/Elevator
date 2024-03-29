<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 2019-10-25
 * Time: 14:45
 */

namespace Mytest\Elevator\Model\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class MyAttributClosedCountry
 * @package Mytest\Elevator\Model\Attribute\Backend
 */
class MyAttributClosedCountry extends AbstractBackend
{
    const PASS_CLOSED_COUNTRY_VAIMO_MYTEST = 'elevator/general/elevator_cloused_country';
    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;
    /**
     * @var CountryFactory
     */
    public $countryFactory;

    /**
     * MyAttributClosedCountry constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param CountryFactory $countryFactory
     */
    public function __construct(ScopeConfigInterface $scopeConfig, CountryFactory $countryFactory)
    {
        $this->scopeConfig   = $scopeConfig;
        $this->countryFactory = $countryFactory;
    }

    /**
     * @param \Magento\Framework\DataObject $object
     *
     * @return bool
     * @throws LocalizedException
     */
    public function validate($object)
    {
         $object->getData($this->getAttribute()->getAttributeCode());
         if($object->getData($this->getAttribute()->getAttributeCode())) {
             $closedCountryCode = array_intersect($object->getData($this->getAttribute()
                 ->getAttributeCode()), $this->getClosedCountry());
             if (empty($closedCountryCode)) {
                 return true;
             }
             $myAnswer = 'You choose closed country : ';
             foreach ($this->getNameCountryByCode($closedCountryCode) as $countryName) {
                 $myAnswer = $myAnswer . $countryName . ' ';
             }
             throw new LocalizedException(__($myAnswer));
         }
         return true;
    }

    /**
     * @return array
     */
    private function getClosedCountry()
    {
        return explode(',',$this->scopeConfig->getValue($this::PASS_CLOSED_COUNTRY_VAIMO_MYTEST));
    }

    /**
     * @param array $codes
     *
     * @return array
     */
    private function getNameCountryByCode(array $codes)
    {
          $names = array();
          foreach ($codes as $countryCode)
          {
              $names[] = $this->countryFactory->create()->loadByCode($countryCode)->getName();
          }
          return $names;
    }
}
