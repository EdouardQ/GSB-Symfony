<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\LineExpenseOutBundle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LineExpenseOutBundleFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list =[
        [
            "wording" => "invitation au restaurant pdg DSB",
            "date" => "2021-04-16",
            "amount" => 200.00,
            "expenseForm" => "equilliou_04-2021",
            "valid" => True,
        ],
        [
            "wording" => "invitation au restaurant pdg DSB",
            "date" => "2021-01-16",
            "amount" => 200.00,
            "expenseForm" => "equilliou_01-2021",
            "valid" => True,
        ],
        [
            "wording" => "invitation au restaurant pdg DSB",
            "date" => "2021-01-16",
            "amount" => 200.00,
            "expenseForm" => "equilliou_01-2021",
            "valid" => False,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $lineExpenseOutBundle) {
            $entity = new LineExpenseOutBundle;
            $entity->setWording($lineExpenseOutBundle["wording"]);
            $entity->setDate(new DateTime( $lineExpenseOutBundle["date"]));
            $entity->setAmount($lineExpenseOutBundle["amount"]);
            $entity->setValid($lineExpenseOutBundle["valid"]);

            $entity->setExpenseForm($this->getReference($lineExpenseOutBundle['expenseForm']));

            $manager->persist($entity);
        }

        $manager->flush();
    }
    
    public function getDependencies(): array
    {
        // liste des fixtures dépendantes
        return [
            ExpenseFormFixtures::class,
        ];
    }
}
