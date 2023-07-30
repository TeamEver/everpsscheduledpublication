<?php

    namespace Ever\ScheduledPublication\Grid;

use Ever\ScheduledPublication\Entity\ScheduledPublication;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class ScheduledPublicationQueryBuilder extends AbstractDoctrineQueryBuilder
{

    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('*')
            ->from($this->dbPrefix . 'scheduledpublication')
            ->orderBy($searchCriteria->getOrderBy(), $searchCriteria->getOrderWay()
            )
            ->setFirstResult($searchCriteria->getOffset())
            ->setMaxResults($searchCriteria->getLimit());

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ($filterName === "id_scheduledpublication") {
                $query->andWhere("id_scheduledpublication = :$filterName");
                $query->setParameter($filterName, $filterValue);

                continue;
            }
            if ($filterName === "status") {
                $query->andWhere("$filterName = :$filterName");
                $query->setParameter($filterName, $filterValue);

                continue;
            }
            $query->andWhere("$filterName like :$filterValue");
            $query->setParameter($filterName, '%' . $filterValue . '%');
        }

        return $query;
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('count(*)');
        $query->from($this->dbPrefix . 'scheduledpublication');

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ($filterName === "status") {
                $query->andWhere("$filterName = :$filterName");
                $query->setParameter($filterName, $filterValue);

                continue;
            }
        }

        return $query;
    }
}
