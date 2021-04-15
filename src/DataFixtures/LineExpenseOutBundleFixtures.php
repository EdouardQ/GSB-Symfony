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
            "wording" => "invitation au restaurant praticien Gosselin Albert",
            "date" => "2021-03-16",
            "amount" => 40.00,
            "expenseForm" => "jdebelle_03-2021",
            "supportingDocument" => "2zhwy2qrjfhslh5mdyeh6eznfsywcssx.pdf",
            "valid" => True,
        ],
        [
            "wording" => "invitation au restaurant praticien Notini Alain",
            "date" => "2021-03-21",
            "amount" => 60.00,
            "expenseForm" => "cenault_03-2021",
            "supportingDocument" => "k1tqtt2c2s4rbkavldda4rdeaiojqn92.pdf",
            "valid" => false,
        ],
        [
            "wording" => "invitation au restaurant praticien Gosselin Albert",
            "date" => "2021-02-16",
            "amount" => 40.00,
            "expenseForm" => "jdebelle_02-2021",
            "supportingDocument" => "ond1p8jfga85ba6zurdwmo3ncjwpq3vy.pdf",
            "valid" => True,
        ],
        [
            "wording" => "invitation au restaurant praticien Notini Alain",
            "date" => "2021-02-21",
            "amount" => 60.00,
            "expenseForm" => "cenault_02-2021",
            "supportingDocument" => null,
            "valid" => false,
        ],
    ];
    
    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $lineExpenseOutBundle) {
            $entity = new LineExpenseOutBundle;
            $entity->setWording($lineExpenseOutBundle["wording"]);
            $entity->setDate(new DateTime( $lineExpenseOutBundle["date"]));
            $entity->setAmount($lineExpenseOutBundle["amount"]);
            $entity->setSupportingDocument($lineExpenseOutBundle["supportingDocument"]);
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
