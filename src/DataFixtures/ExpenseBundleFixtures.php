<?php

namespace App\DataFixtures;

use App\Entity\ExpenseBundle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ExpenseBundleFixtures extends Fixture
{
    private array $list = [
        [
            "libelle" => "Forfait Etape",
            "montant" => 110.00
        ],
        [
            "libelle" => "Frais Kilométrique",
            "montant" => 0.62
        ],
        [
            "libelle" => "Nuitée Hôtel",
            "montant" => 80.00
        ],
        [
            "libelle" => "Repas Restaurant",
            "montant" => 25.00
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $expenseBundle) {
            $entity = new ExpenseBundle;
            $entity->setLibelle($expenseBundle["libelle"]);
            $entity->setMontant($expenseBundle["montant"]);

            $this->addReference($expenseBundle['libelle'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
