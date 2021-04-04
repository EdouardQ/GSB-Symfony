<?php

namespace App\DataFixtures;

use App\DataFixtures\WorkplaceFixtures;
use App\Entity\Practitioner;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PractitionerFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list = [
        [
            'name' => 'Notini',
            'firstName' => 'Alain',
            'adress' => "114 rue Authie",
            'city' => "La Roche sur Yon",
            'postalCode' => '85000',
            'coeffReputation' => '290.03',
            'workplace' => "Médecin Hospitalier"
        ],
        [
            'name' => 'Gosselin',
            'firstName' => 'Albert',
            'adress' => "13 rue Devon",
            'city' => "Blois",
            'postalCode' => '41000',
            'coeffReputation' => '307.49',
            'workplace' => "Médecine de Ville"
        ],
        [
            'name' => 'Delahaye',
            'firstName' => 'André',
            'adress' => "36 av 6 juin",
            'city' => "Besancon",
            'postalCode' => '25000',
            'coeffReputation' => '185.79',
            'workplace' => "Personnel de Santé"
        ],
        [
            'name' => 'Leroux',
            'firstName' => 'André',
            'adress' => "47 av Robert Schuman",
            'city' => "Beauvais",
            'postalCode' => '60000',
            'coeffReputation' => '172.04',
            'workplace' => "Pharmacien Hospitalier"
        ],
        [
            'name' => 'Desmoulins',
            'firstName' => 'Anne',
            'adress' => "31 rue St Jean",
            'city' => "Nimes",
            'postalCode' => '30000',
            'coeffReputation' => '94.75',
            'workplace' => "Pharmacien Officine"
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $practitioner) {
            $entity = new Practitioner;

            $entity->setName($practitioner['name']);
            $entity->setFirstName($practitioner['firstName']);
            $entity->setAdress($practitioner['adress']);
            $entity->setCity($practitioner['city']);
            $entity->setPostalCode($practitioner['postalCode']);
            $entity->setCoeffReputation($practitioner['coeffReputation']);

            $entity->setWorkplace($this->getReference($practitioner['workplace']));

            $this->addReference($practitioner['name']." ".$practitioner['firstName'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // liste des fixtures dépendantes
        return [
            WorkplaceFixtures::class,
        ];
    }
}
