<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\Plugin\Elasticsearch\SearchAdapter\Query\Builder;

use Magento\Elasticsearch\SearchAdapter\Query\Builder\Aggregation as MagentoAggregation;

class Aggregation
{
    /**
     * @param MagentoAggregation $subject
     * @param array $result
     * @return array
     */
    public function afterBuild(MagentoAggregation $subject, array $result): array
    {
        $result['body']['aggregations']['custom_bucket'] = [
            'filters' => [
                'filters' => [
                    'Value1' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => [
                                        'material' => [
                                            'value' => 38
                                        ]
                                    ]
                                ],
                                [
                                    'term' => [
                                        'activity' => [
                                            'value' => 11
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'Value2' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => [
                                        'new' => [
                                            'value' => 1
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'Value3' => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => [
                                        'sale' => [
                                            'value' => 1
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $result;
    }
}
