<?php
namespace BileMo\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends AbstractRepository {

    public function findAllPaginated($limit = 20, $offset = 0, $attributeToOrderBy = '', $order = 'asc', $relatedEntityClass = 'BileMo\AppBundle\Entity\User' )
    {
        // Last attribute is Entity related Class, so that the method can check if the entity class has attribute to order results by.
        return parent::findAllPaginated($limit, $offset, $attributeToOrderBy, $order, $relatedEntityClass);
    }

} 
