<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\Plugin\Search\Model;

use Ajourquin\CustomProductFilter\Search\Request\Aggregation\FilterBucketFactory;
use Magento\Framework\Search\Request\Aggregation\MetricFactory;
use Magento\Framework\Search\RequestFactory;
use Magento\Framework\Search\RequestInterface;
use Magento\Search\Model\SearchEngine as MagentoSearchEngine;

class SearchEngine
{
    /** @var RequestFactory */
    private $requestFactory;

    /** @var FilterBucketFactory */
    private $filterBucketFactory;

    /** @var MetricFactory */
    private $metricFactory;

    /**
     * SearchEngine constructor.
     * @param RequestFactory $requestFactory
     * @param FilterBucketFactory $filterBucketFactory
     * @param MetricFactory $metricFactory
     */
    public function __construct(
        RequestFactory $requestFactory,
        FilterBucketFactory $filterBucketFactory,
        MetricFactory $metricFactory
    ) {
        $this->requestFactory = $requestFactory;
        $this->filterBucketFactory = $filterBucketFactory;
        $this->metricFactory = $metricFactory;
    }

    /**
     * @param MagentoSearchEngine $subject
     * @param RequestInterface $param
     * @return array
     */
    public function beforeSearch(MagentoSearchEngine $subject, RequestInterface $param): array
    {
        $customBucket = $this->filterBucketFactory->create([
            'name' => 'custom_bucket',
            'field' => 'custom',
            'metrics' => [
                $this->metricFactory->create([
                    'type' => 'count'
                ])
            ]
        ]);

        $buckets = $param->getAggregation();
        $buckets[] = $customBucket;

        $requestData = [
            'name' => $param->getName(),
            'indexName' => $param->getIndex(),
            'from' => $param->getFrom(),
            'size' => $param->getSize(),
            'query' => $param->getQuery(),
            'dimensions' => $param->getDimensions(),
            'buckets' => $buckets,
            'sort' => $param->getSort()
        ];

        $request = $this->requestFactory->create($requestData);

        return [$request];
    }
}
