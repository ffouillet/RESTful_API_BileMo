<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

abstract class AbstractRepository extends EntityRepository
{

    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 0)
    {

        if (0 == $limit) {
            throw new \LogicException('$limit must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil(($offset + 1) / $limit);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }

    protected function getQueryBuilderOrderedBy($attributeToOrderBy = '', $order = 'asc', $relatedEntityClass = '') {

        $reflect =  new \ReflectionClass($this);

        $currentClassFirstChar = strtolower(substr($reflect->getShortName(),0,1));
        $queryBuilder = $this->createQueryBuilder($currentClassFirstChar);

        if($attributeToOrderBy != '') {
            if($relatedEntityClass != '') {
                // Check if class has attribute
                if(property_exists($relatedEntityClass, $attributeToOrderBy)) {
                    $queryBuilder->orderBy($currentClassFirstChar.'.'.$attributeToOrderBy, $order);
                } else {
                    throw new \Exception('Unable to order results with attribute '.$attributeToOrderBy.' as required resource don\'t have this attribute.');
                }
            } else {
                throw new \Exception('You must set the parameter relatedEntityClass so that the method can check that the relatedEntityClass has the requested attribute to order results by.');
            }
        }

        return $queryBuilder;
    }

    protected function findAllPaginated($limit = 20, $offset = 0, $attributeToOrderBy = '', $order = 'asc', $relatedEntityClass = '') {

        $queryBuilder = $this->getQueryBuilderOrderedBy($attributeToOrderBy, $order, $relatedEntityClass);

        return $this->paginate($queryBuilder, $limit, $offset);
    }

}