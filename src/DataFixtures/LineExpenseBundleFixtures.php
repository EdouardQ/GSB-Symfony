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
            "quantity" => 40,
            "date" => '2021-02-16',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "jdebelle_02-2021"
        ],
        [
            "quantity" => 120,
            "date" => '2021-02-20',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "ffremont_02-2021"
        ],
        [
            "quantity" => 50,
            "date" => '2021-02-21',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "cenault_02-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-02-16',
            "expenseBundle" => "Nuitée Hôtel",
            "expenseForm" => "jdebelle_02-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-02-20',
            "expenseBundle" => "Nuitée Hôtel",
            "expenseForm" => "ffremont_02-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-02-21',
            "expenseBundle" => "Forfait Etape",
            "expenseForm" => "cenault_02-2021"
        ],
        [
            "quantity" => 2,
            "date" => '2021-02-16',
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "jdebelle_02-2021"
        ],
        [
            "quantity" => 2,
            "date" => '2021-02-20',
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "ffremont_02-2021"
        ],

        [
            "quantity" => 40,
            "date" => '2021-03-16',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "jdebelle_03-2021"
        ],
        [
            "quantity" => 120,
            "date" => '2021-03-20',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "ffremont_03-2021"
        ],
        [
            "quantity" => 50,
            "date" => '2021-03-21',
            "expenseBundle" => "Frais Kilométriques",
            "expenseForm" => "cenault_03-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-03-16',
            "expenseBundle" => "Nuitée Hôtel",
            "expenseForm" => "jdebelle_03-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-03-20',
            "expenseBundle" => "Nuitée Hôtel",
            "expenseForm" => "ffremont_03-2021"
        ],
        [
            "quantity" => 1,
            "date" => '2021-03-21',
            "expenseBundle" => "Forfait Etape",
            "expenseForm" => "cenault_03-2021"
        ],
        [
            "quantity" => 2,
            "date" => '2021-03-16',
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "jdebelle_03-2021"
        ],
        [
            "quantity" => 2,
            "date" => '2021-03-20',
            "expenseBundle" => "Repas Restaurant",
            "expenseForm" => "ffremont_03-2021"
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $lineExpenseBundle) {
            $entity = new LineExpenseBundle;
            $entity->setQuantity($lineExpenseBundle['quantity']);
            $entity->setDate(new DateTime($lineExpenseBundle['date']));

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
