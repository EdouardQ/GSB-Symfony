<?php

namespace App\DataFixtures;

use App\Entity\Workplace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkplaceFixtures extends Fixture
{
    private array $list = [
        [
            'wording' => "Médecin Hospitalier",
        ],
        [
            'wording' => "Médecine de Ville",
        ],
        [
            'wording' => "Personnel de Santé",
        ],
        [
            'wording' => "Pharmacien Hospitalier",
        ],
        [
            'wording' => "Pharmacien Officine",
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $workplace) {
            $entity = new Workplace;

            $entity->setWording($workplace['wording']);

            $this->addReference($workplace['wording'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
