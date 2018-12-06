<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\MobilePhone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MobilePhoneFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // Fake phones datas (could be far from reality, sorry!)
        $fakePhonesDatas =
            [
                'namePrefixes' => ['BMPhone-','BileMo-X-','BileMo-Tel-'],
                'batteryCapacities' => [1000,1500,2000,2500,3000,3500], // in mAh
                'builtInStorages' => [2,4,8,16,32], // in GB
                'cpuClockSpeeds' => [1000,1200,1400,1600,1800,2000,2200,2400,2600], // in MHz
                'ram' => [2,4,8,16], // in GB
                'cameraResolutions' => [2,4,8,16,32] // in Mpx
            ];

        $nbrPhonesToCreate = 30;

        for($i = 1; $i <= $nbrPhonesToCreate; $i++) {
            $mobilePhone = new MobilePhone();

            // Phone name
            $mobilePhoneName = $fakePhonesDatas['namePrefixes'][array_rand($fakePhonesDatas['namePrefixes'])];
            $mobilePhoneName .= mt_rand(0,1000);
            $mobilePhone->setName($mobilePhoneName);

            // Phone price
            $phonePrice = mt_rand(200,800);
            $phonePrice += (mt_rand(2,8)/10);
            $mobilePhone->setPrice($phonePrice);

            // Phone release date
            $phoneReleaseDateAsTimeStamp = time() - mt_rand(0,63072000); // 63 072 000 approx two years in seconds.
            $phoneReleaseDate = new \DateTime();
            $phoneReleaseDate->setTimestamp($phoneReleaseDateAsTimeStamp);
            $mobilePhone->setReleasedAt($phoneReleaseDate);

            // Phone battery capacity
            $phoneBatteryCapacity = $fakePhonesDatas['batteryCapacities'][array_rand($fakePhonesDatas['batteryCapacities'])];
            $mobilePhone->setBatteryCapacity($phoneBatteryCapacity);

            // Phone built in storage
            $phoneBuiltInStorage = $fakePhonesDatas['builtInStorages'][array_rand($fakePhonesDatas['builtInStorages'])];
            $mobilePhone->setBuiltInStorage($phoneBuiltInStorage);

            // Phone CPU Clock Speed
            $phoneCpuClockSpeed = $fakePhonesDatas['cpuClockSpeeds'][array_rand($fakePhonesDatas['cpuClockSpeeds'])];
            $phoneCpuClockSpeed /= 1000; // Set in GHz
            $mobilePhone->setCpuClockSpeed($phoneCpuClockSpeed);

            // Phone RAM
            $phoneRAM = $fakePhonesDatas['ram'][array_rand($fakePhonesDatas['ram'])];
            $mobilePhone->setRam($phoneRAM);

            // Phone Rear and Front camera resolutions
            $phoneFrontCameraResolution = $fakePhonesDatas['cameraResolutions'][array_rand($fakePhonesDatas['cameraResolutions'])];
            $phoneRearCameraResolution = $fakePhonesDatas['cameraResolutions'][array_rand($fakePhonesDatas['cameraResolutions'])];
            $mobilePhone->setFrontCameraResolution($phoneFrontCameraResolution);
            $mobilePhone->setRearCameraResolution($phoneRearCameraResolution);

            $manager->persist($mobilePhone);
        }

        $manager->flush();
    }
}