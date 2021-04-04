<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\PractitionerFixtures;
use App\Entity\Report;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReportFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list = [
        [
            'user' => 'equilliou',
            'practitioner' => 'Notini Alain',
            'date' => '2021-02-14',
            'reasonVisit' => "Visite promotion antifongique TRYMICINE",
            'summary' => "Visite promotion antifongique chez le généraliste Notini Alain, échantillons offerts.",
        ],
        [
            'user' => 'equilliou',
            'practitioner' => 'Gosselin Albert',
            'date' => '2021-03-16',
            'reasonVisit' => "Visite promotion antibiotique ADIMOL",
            'summary' => "Visite promotion antibiotique chez le généraliste Gosselin Albert, échantillons offerts.",
        ],

    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $report) {
            $entity = new Report;

            $entity->setDate( new DateTime($report['date']));
            $entity->setReasonVisit($report['reasonVisit']);
            $entity->setSummary($report['summary']);

            $entity->setUser($this->getReference($report['user']));
            $entity->setPractitioner($this->getReference($report['practitioner']));

            $this->addReference($report['practitioner']."_".$report['date'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // liste des fixtures dépendantes
        return [
            UserFixtures::class,
            PractitionerFixtures::class,
        ];
    }
}
