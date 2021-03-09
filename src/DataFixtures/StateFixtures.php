<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    private array $list = [
        [
            "libelle" => "Remboursée",
        ],
        [
            "libelle" => "Saisie clôturée",
        ],
        [
            "libelle" => "Fiche créée, saisie en cours",
        ],
        [
            "libelle" => "Validée et mise en paiement",
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $state) {
            $entity = new State;
            $entity->setLibelle($state("libelle"));

            $this->addReference($state['libelle'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
