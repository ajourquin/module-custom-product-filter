<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\Model\Layer\Filter;

use Magento\Catalog\Model\Layer\Filter\AbstractFilter;
use Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection as ProductCollection;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\StateException;

class Custom extends AbstractFilter
{
    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function apply(RequestInterface $request): self
    {
        $labels = [];
        $this->setRequestVar($this->getData('request_var'));
        $attributeValue = $request->getParam($this->_requestVar);

        if ($attributeValue === null) {
            return $this;
        }

        $this->filterCollection($attributeValue);

        foreach ((array) $attributeValue as $value) {
            $label = $value;
            $labels[] = \is_array($label)
                ? $label
                : [$label];
        }

        $label = \implode(',', \array_unique(\array_merge(...$labels)));
        $this->getLayer()->getState()->addFilter($this->_createItem($label, $attributeValue));
        $this->setItems([]); // set items to disable show filtering

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return \__('Custom layered')->render();
    }

    /**
     * @return array
     * @throws StateException
     */
    protected function _getItemsData()
    {
        $this->setRequestVar($this->getData('request_var'));

        /** @var ProductCollection $productCollection */
        $productCollection = $this->getLayer()->getProductCollection();
        $optionsFacetedData = $productCollection->getFacetedData('custom');

        if (\count($optionsFacetedData) > 0) {
            foreach ($optionsFacetedData as $option) {
                if ($option['count'] > 0) {
                    $this->itemDataBuilder->addItemData(
                        \strip_tags($option['value']),
                        $option['value'],
                        $option['count']
                    );
                }
            }
        }

        return $this->itemDataBuilder->build();
    }

    /**
     * @param string $attributeValue
     * @return ProductCollection
     */
    private function filterCollection(string $attributeValue): ProductCollection
    {
        $collection = $this->getLayer()->getProductCollection();

        switch ($attributeValue) {
            case 'Value1':
                $collection->addFieldToFilter('material', 38);
                $collection->addFieldToFilter('activity', 11);
                break;
            case 'Value2':
                $collection->addFieldToFilter('new', 1);
                break;
            case 'Value3':
                $collection->addFieldToFilter('sale', 1);
                break;
        }

        return $collection;
    }
}
