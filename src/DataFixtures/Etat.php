<?php

namespace App\DataFixtures;

use App\Entity\Etat as EntityEtat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Etat extends Fixture
{
    private array $list = [
        [
            'id' => 'RB',
            'libelle' => 'Remboursée'
        ],
        [
            'id' => 'CL',
            'libelle' => 'Saisie Cloturée'
        ],
        [
            'id' => 'CR',
            'libelle' => 'Fiche créée, saisie en cours'
        ],
        [
            'id' => 'VA',
            'libelle' => 'Validée et mise en paiement'
        ],
    ];


    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $etatfiche) {
            $etat = new EntityEtat;
            $etat->setId($etatfiche['id']);
            $etat->setLibelle($etatfiche['libelle']);

            $manager->persist($etat);
        }

        $manager->flush();
    }
}
