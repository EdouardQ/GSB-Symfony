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
            "mois" => "02-2021",
            "nbJustificatifs" => 2,
            "montantValide" => 203.00,
            "dateModif" => '12:00:00 2021-02-28',
            "state" => "Saisie clôturée",
            "token" => "equilliou_02-2021"
        ],
        [
            "user" => "equilliou",
            "mois" => "01-2021",
            "nbJustificatifs" => 2,
            "montantValide" => 225.00,
            "dateModif" => '12:30:49 2021-01-27',
            "state" => "Remboursée",
            "token" => "equilliou_01-2021"
        ],
        [
            "user" => "agest",
            "mois" => "01-2021",
            "nbJustificatifs" => 2,
            "montantValide" => 118.00,
            "dateModif" => '12:30:49 2021-01-27',
            "state" => "Remboursée",
            "token" => "agest_01-2021"
        ],
    ];


    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $expenseForm) {
            $entity = new ExpenseForm;
            $entity->setMois($expenseForm["mois"]);
            $entity->setNbJustificatifs($expenseForm["nbJustificatifs"]);
            $entity->setMontantValide($expenseForm["montantValide"]);
            $entity->setDateModif(new DateTime( $expenseForm["dateModif"]));
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
