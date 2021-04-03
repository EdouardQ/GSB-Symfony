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
            "libelle" => "invitation au restaurant pdg DSB",
            "date" => "2021-04-16",
            "montant" => 200.00,
            "expenseForm" => "equilliou_04-2021"
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $lineExpenseOutBundle) {
            $entity = new LineExpenseOutBundle;
            $entity->setLibelle($lineExpenseOutBundle["libelle"]);
            $entity->setDate(new DateTime( $lineExpenseOutBundle["date"]));
            $entity->setMontant($lineExpenseOutBundle["montant"]);

            $entity->setExpenseForm($this->getReference($lineExpenseOutBundle['expenseForm']));


            $manager->persist($entity);
        }

        $manager->flush();
    }
    
    public function getDependencies():array
    {
        // liste des fixtures dépendantes
        return [
            ExpenseFormFixtures::class,
        ];
    }
}
