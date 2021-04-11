<?php

namespace App\DataFixtures;

use App\Entity\ExpenseBundle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ExpenseBundleFixtures extends Fixture
{
    private array $list = [
        [
            "wording" => "Forfait Etape",
            "amount" => 110.00
        ],
        [
            "wording" => "Frais Kilométrique",
            "amount" => 0.62
        ],
        [
            "wording" => "Nuitée Hôtel",
            "amount" => 80.00
        ],
        [
            "wording" => "Repas Restaurant",
            "amount" => 25.00
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $expenseBundle) {
            $entity = new ExpenseBundle;
            $entity->setWording($expenseBundle["wording"]);
            $entity->setAmount($expenseBundle["amount"]);

            $this->addReference($expenseBundle['wording'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
