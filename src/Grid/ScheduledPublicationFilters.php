<?php

declare(strict_types=1);

    namespace Ever\ScheduledPublication\Grid;

    use Module\DemoGrid\Grid\Definition\Factory\ProductGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class ScheduledPublicationFilters extends Filters
{
    protected $filterId = ScheduledPublicationGridDefinitionFactory::GRID_ID;

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 30,
            'offset' => 0,
            'orderBy' => 'due_date',
            'sortOrder' => 'desc',
            'filters' => [],
        ];
    }
}
