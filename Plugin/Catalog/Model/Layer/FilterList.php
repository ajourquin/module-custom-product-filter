<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\Plugin\Catalog\Model\Layer;

use Ajourquin\CustomProductFilter\Model\Layer\Filter\Custom as CustomFilter;
use Ajourquin\CustomProductFilter\Model\Layer\Filter\CustomFactory as CustomFilterFactory;
use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\FilterList as MagentoFilterList;

class FilterList
{
    /** @var CustomFilter */
    private $customFilter;

    /** @var CustomFilterFactory */
    private $customFilterFactory;

    /**
     * FilterList constructor.
     * @param CustomFilterFactory $customFilterFactory
     */
    public function __construct(
        CustomFilterFactory $customFilterFactory
    ) {
        $this->customFilterFactory = $customFilterFactory;
    }

    /**
     * @param MagentoFilterList $subject
     * @param array $result
     * @param Layer $layer
     * @return array
     */
    public function afterGetFilters(MagentoFilterList $subject, array $result, Layer $layer): array
    {
        \array_push($result, $this->getCustomFilter($layer));

        return $result;
    }

    /**
     * @param Layer $layer
     * @return CustomFilter
     */
    private function getCustomFilter(Layer $layer): CustomFilter
    {
        if ($this->customFilter === null) {
            $this->customFilter = $this->customFilterFactory->create([
                'data' => [
                    'request_var' => 'custom'
                ],
                'layer' => $layer
            ]);
        }

        return $this->customFilter;
    }
}
