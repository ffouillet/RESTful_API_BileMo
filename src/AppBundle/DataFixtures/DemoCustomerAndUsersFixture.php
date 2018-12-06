<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DemoCustomerAndUsersFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $demoCustomer = new Customer();
        $demoCustomer->setFullName('BileMo\'s Demo Customer');
        $demoCustomer->setUsername('bileMoDemoCustomer');
        $demoCustomer->setEmail('demoCustomer@demoCustomerMobileShop.com');
        $demoCustomer->setWebsiteUrl('http://www.bileMoDemoCustomerMobileShop.com');


        $demoUser = new User();

        $demoUser->setUsername('demoUser');
        $demoUser->setPlainPassword('demoPassword');
        $demoUser->setEmail('demoMail@demo.com');
        $demoUser->setFirstName('DemoFirstName');
        $demoUser->setLastName('DemoLastName');
        $demoUser->setCreatedAt(new \DateTime());

        $manager->persist($demoUser);

        $manager->flush();
    }
}