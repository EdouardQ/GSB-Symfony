<?php

namespace App\DataFixtures;

use App\Entity\FraisForfait as EntityFraisForfait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FraisForfait extends Fixture
{   
    private array $list = [
        [
            'id' => 'EPT',
            'libelle' => 'Forfait Etape',
            'montant' => 110.00,
        ],
        [
            'id' => 'KM',
            'libelle' => 'Frais Kilométrique',
            'montant' => 0.62,
        ],
        [
            'id' => 'NUI',
            'libelle' => 'Nuitée Hôtel',
            'montant' => 80.00,
        ],
        [
            'id' => 'REM',
            'libelle' => 'Repas Restaurant',
            'montant' => 25.00,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $frais) {
            $fraisforfait = new EntityFraisForfait;
            $fraisforfait->setId($frais['id']);
            $fraisforfait->setLibelle($frais['libelle']);
            $fraisforfait->setMontant($frais['montant']);

            $manager->persist($fraisforfait);
        }

        $manager->flush();
    }
}
