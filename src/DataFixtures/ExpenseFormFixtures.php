<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\ExpenseForm;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExpenseFormFixtures extends Fixture implements DependentFixtureInterface
{
    private array $list = [
        [
            "user" => "equilliou",
            "month" => "04-2021",
            "nbSupportingDocuments" => 3,
            "validAmount" => 319.30,
            "dateUpdate" => '12:00:00 2021-04-3',
            "state" => "Fiche créée, saisie en cours",
            "token" => "equilliou_04-2021"
        ],
        [
            "user" => "equilliou",
            "month" => "01-2021",
            "nbSupportingDocuments" => 2,
            "validAmount" => 225.00,
            "dateUpdate" => '12:30:49 2021-01-27',
            "state" => "Remboursée",
            "token" => "equilliou_01-2021"
        ],
        [
            "user" => "agest",
            "month" => "01-2021",
            "nbSupportingDocuments" => 2,
            "validAmount" => 118.00,
            "dateUpdate" => '12:30:49 2021-01-27',
            "state" => "Remboursée",
            "token" => "agest_01-2021"
        ],
    ];


    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $expenseForm) {
            $entity = new ExpenseForm;
            $entity->setMonth($expenseForm["month"]);
            $entity->setNbSupportingDocuments($expenseForm["nbSupportingDocuments"]);
            $entity->setValidAmount($expenseForm["validAmount"]);
            $entity->setDateUpdate(new DateTime( $expenseForm["dateUpdate"]));
            $entity->setToken($expenseForm["token"]);

            $entity->setUser($this->getReference($expenseForm['user']));
            $entity->setState($this->getReference($expenseForm['state']));

            $this->addReference($expenseForm['token'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
    
    public function getDependencies():array
    {
        // liste des fixtures dépendantes
        return [
            UserFixtures::class,
            StateFixtures::class,
        ];
    }
}
