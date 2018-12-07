<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NoResultException;

class CustomerProvider implements UserProviderInterface
{
    protected $customerRepository;

    public function __construct(ObjectRepository $customerRepository){
        $this->customerRepository = $customerRepository;
    }

    public function loadUserByUsername($customername)
    {
        $q = $this->customerRepository
            ->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $customername)
            ->getQuery();

        try {
            $customer = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active customer identified by "%s". Please verify username.',
                $customername
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $customer;
    }

    public function refreshUser(UserInterface $customer)
    {
        $class = get_class($customer);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->customerRepository->find($customer->getId());
    }

    public function supportsClass($class)
    {
        return $this->customerRepository->getClassName() === $class
            || is_subclass_of($class, $this->customerRepository->getClassName());
    }
}
