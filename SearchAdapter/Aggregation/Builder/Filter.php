<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\SearchAdapter\Aggregation\Builder;

use Magento\Elasticsearch\SearchAdapter\Aggregation\Builder\BucketBuilderInterface;
use Magento\Framework\Search\Dynamic\DataProviderInterface;
use Magento\Framework\Search\Request\BucketInterface as RequestBucketInterface;

class Filter implements BucketBuilderInterface
{
    /**
     * @param RequestBucketInterface $bucket
     * @param array $dimensions
     * @param array $queryResult
     * @param DataProviderInterface $dataProvider
     * @return array
     */
    public function build(
        RequestBucketInterface $bucket,
        array $dimensions,
        array $queryResult,
        DataProviderInterface $dataProvider
    ): array {
        $buckets = $queryResult['aggregations'][$bucket->getName()]['buckets'] ?? [];
        $values = [];

        foreach ($buckets as $value => $resultBucket) {
            $values[$value] = [
                'value' => $value,
                'count' => $resultBucket['doc_count'],
            ];
        }

        return $values;
    }
}
