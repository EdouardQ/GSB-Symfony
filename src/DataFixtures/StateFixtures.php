<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    private array $list = [
        [
            "wording" => "Remboursée",
        ],
        [
            "wording" => "Saisie clôturée",
        ],
        [
            "wording" => "Fiche créée, saisie en cours",
        ],
        [
            "wording" => "Validée et mise en paiement",
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $state) {
            $entity = new State;
            $entity->setWording($state["wording"]);

            $this->addReference($state['wording'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
