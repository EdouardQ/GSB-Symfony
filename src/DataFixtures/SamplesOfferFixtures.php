<?php

namespace App\DataFixtures;

use App\DataFixtures\ReportFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\MedicationFixtures;
use App\Entity\SamplesOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SamplesOfferFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list = [
        [
            'report' => "Notini Alain_2021-02-14",
            'medication' => 'TRYMICINE',
            'quantity' => 5,
        ],
        [
            'report' => "Gosselin Albert_2021-03-16",
            'medication' => 'TRYMICINE',
            'quantity' => 2,
        ],
        [
            'report' => "Gosselin Albert_2021-03-16",
            'medication' => 'ADIMOL',
            'quantity' => 10,
        ],

    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $samplesOffert) {
            $entity = new SamplesOffer;

            $entity->setReport($this->getReference($samplesOffert['report']));
            $entity->setMedication($this->getReference($samplesOffert['medication']));

            $entity->setQuantity($samplesOffert['quantity']);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // liste des fixtures dépendantes
        return [
            ReportFixtures::class,
            MedicationFixtures::class,
        ];
    }
}
