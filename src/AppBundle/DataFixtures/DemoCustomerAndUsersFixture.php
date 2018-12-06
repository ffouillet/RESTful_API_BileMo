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
        $demoCustomer->setCompanyName('BileMo\'s Demo Customer Company');
        $demoCustomer->setUsername('bileMoDemoCustomer');
        $demoCustomer->setPlainPassword('bileMoDemoCustomerPassword');
        $demoCustomer->setEmail('demoCustomer@demoCustomerMobileShop.com');
        $demoCustomer->setWebsiteUrl('http://www.bileMoDemoCustomerMobileShop.com');

        $manager->persist($demoCustomer);

        // Generate demoCustomer's users.
        for($i = 0; $i <= 10; $i++) {

            $demoUser = new User();
            $demoUser->setUsername('demoUser'.$i);
            $demoUser->setPlainPassword('demoPassword'.$i);
            $demoUser->setEmail('demoMail'.$i.'@demo.com');
            $demoUser->setFirstName('DemoUser'.$i.'FirstName');
            $demoUser->setLastName('DemoUser'.$i.'LastName');
            $demoUser->setCreatedAt(new \DateTime());
            $demoUser->setCustomer($demoCustomer);

            $manager->persist($demoUser);
        }

        $manager->flush();
    }
}