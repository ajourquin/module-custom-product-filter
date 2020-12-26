<?php

/**
 * @author Aurélien Jourquin <aurelien@growzup.com>
 * @link http://www.ajourquin.com
 */

declare(strict_types=1);

namespace Ajourquin\CustomProductFilter\Search\Request\Aggregation;

use Magento\Framework\Search\Request\BucketInterface;

class FilterBucket implements BucketInterface
{
    public const TYPE_FILTER = 'filterBucket';

    /** @var string */
    private $name;

    /** @var string */
    private $field;

    /** @var array */
    private $metrics;

    /**
     * FilterBucket constructor.
     * @param string $name
     * @param string $field
     * @param array $metrics
     */
    public function __construct(
        string $name,
        string $field,
        array $metrics
    ) {
        $this->name = $name;
        $this->field = $field;
        $this->metrics = $metrics;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_FILTER;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return array
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }
}
