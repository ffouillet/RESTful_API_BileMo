<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DemoUserFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
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