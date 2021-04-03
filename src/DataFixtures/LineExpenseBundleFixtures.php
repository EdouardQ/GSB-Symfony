<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\LineExpenseBundle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LineExpenseBundleFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list =[
        [
            "quantite" => 15,
            "expenseBundle" => "Frais Kilométrique",
            "expenseForm" => "equilliou_04-2021"
        ],
        [
            "quantite" => 1,
            "expenseBundle" => "Forfait Etape",
            "expenseForm" => "equilliou_04-2021"
        ],
        [
            "quantite" => 1,
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "equilliou_01-2021"
        ],
        [
            "quantite" => 15,
            "expenseBundle" => "Frais Kilométrique",
            "expenseForm" => "agest_01-2021"
        ],
        [
            "quantite" => 1,
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "agest_01-2021"
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $lineExpenseBundle) {
            $entity = new LineExpenseBundle;
            $entity->setQuantite($lineExpenseBundle["quantite"]);

            $entity->setExpenseForm($this->getReference($lineExpenseBundle['expenseForm']));
            $entity->setExpenseBundle($this->getReference($lineExpenseBundle['expenseBundle']));


            $manager->persist($entity);
        }

        $manager->flush();
    }
    
    public function getDependencies():array
    {
        // liste des fixtures dépendantes
        return [
            ExpenseFormFixtures::class,
            ExpenseBundleFixtures::class,
        ];
    }
}
