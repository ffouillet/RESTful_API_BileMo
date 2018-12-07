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
        $demoCustomer->setCompanyName('Blue Mobile Shop');
        $demoCustomer->setUsername('blueMobileShop');
        $demoCustomer->setPlainPassword('blueMobilePassword');
        $demoCustomer->setEmail('dev@blueMobileShop.com');
        $demoCustomer->setWebsiteUrl('http://www.blueMobileShop.com');

        $manager->persist($demoCustomer);

        $otherDemoCustomer = new Customer();
        $otherDemoCustomer->setCompanyName('Red Mobile Shop');
        $otherDemoCustomer->setUsername('redMobileShop');
        $otherDemoCustomer->setPlainPassword('redMobilePassword');
        $otherDemoCustomer->setEmail('dev@redMobileShop.com');
        $otherDemoCustomer->setWebsiteUrl('http://www.redMobileShop.com');

        $manager->persist($otherDemoCustomer);

        // Generate demoCustomer's users.
        for($i = 1; $i <= 20; $i++) {

            $demoUser = new User();

            if ($i < 11) {
                $demoUser->setUsername('blue-demoUser-'.$i);
                $demoUser->setPlainPassword('demoPassword'.$i);
                $demoUser->setEmail('demoMail'.$i.'@blueMobileShop.com');
                $demoUser->setFirstName('BlueDemoUser-'.$i.'-FirstName');
                $demoUser->setLastName('BlueDemoUser-'.$i.'-LastName');
                $demoUser->setCreatedAt(new \DateTime());
                $demoUser->setCustomer($demoCustomer);
            } else {
                $demoUser->setUsername('red-demoUser-'.$i);
                $demoUser->setPlainPassword('demoPassword'.$i);
                $demoUser->setEmail('demoMail'.$i.'@redMobileShop.com');
                $demoUser->setFirstName('RedDemoUser'.$i.'FirstName');
                $demoUser->setLastName('RedDemoUser'.$i.'LastName');
                $demoUser->setCreatedAt(new \DateTime());
                $demoUser->setCustomer($otherDemoCustomer);
            }

            $manager->persist($demoUser);
        }

        $manager->flush();
    }
}