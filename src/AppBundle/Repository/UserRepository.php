<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends AbstractRepository
{

    public function findAllPaginated($limit = 20, $offset = 0, $attributeToOrderBy = '', $order = 'asc', $relatedEntityClass = 'AppBundle\Entity\User')
    {
        // Last attribute is Entity related Class, so that the method can check if the entity class has attribute to order results by.
        return parent::findAllPaginated($limit, $offset, $attributeToOrderBy, $order, $relatedEntityClass);
    }

    public function findAllByCustomerPaginated(Customer $customer, $limit = 20, $offset = 0, $attributeToOrderBy = '', $order, $relatedEntityClass = 'AppBundle\Entity\User')
    {
        $queryBuilder = $this->getQueryBuilderOrderedBy($attributeToOrderBy, $order, $relatedEntityClass);

        $queryBuilder->where('u.customer = :customer');
        $queryBuilder->setParameter('customer', $customer);

        return $this->paginate($queryBuilder, $limit, $offset);
    }

    public function findOneByCustomerAndId($id, Customer $customer) {

        $qb = $this->createQueryBuilder('u');
        $qb->where('u.id = :id');
        $qb->andWhere('u.customer = :customer');
        $qb->setParameters(['id' => $id, 'customer' => $customer]);

        return $qb->getQuery()->getSingleResult();
    }

}