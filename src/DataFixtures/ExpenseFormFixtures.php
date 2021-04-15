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
            "user" => "ffremont",
            "month" => "02-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 204.40,
            "dateUpdate" => '12:00:00 2021-02-25',
            "state" => "Remboursée",
            "token" => "ffremont_02-2021"
        ],
        [
            "user" => "jdebelle",
            "month" => "02-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 194.80,
            "dateUpdate" => '12:30:49 2021-02-27',
            "state" => "Remboursée",
            "token" => "jdebelle_02-2021"
        ],
        [
            "user" => "cenault",
            "month" => "02-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 141.00,
            "dateUpdate" => '12:30:49 2021-02-27',
            "state" => "Validée et mise en paiement",
            "token" => "cenault_02-2021"
        ],
        [
            "user" => "ffremont",
            "month" => "03-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 204.40,
            "dateUpdate" => '12:00:00 2021-03-25',
            "state" => "Saisie clôturée",
            "token" => "ffremont_03-2021"
        ],
        [
            "user" => "jdebelle",
            "month" => "03-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 194.80,
            "dateUpdate" => '12:30:49 2021-03-27',
            "state" => "Saisie clôturée",
            "token" => "jdebelle_03-2021"
        ],
        [
            "user" => "cenault",
            "month" => "03-2021",
            "nbSupportingDocuments" => 0,
            "validAmount" => 141.00,
            "dateUpdate" => '12:30:49 2021-03-27',
            "state" => "Saisie clôturée",
            "token" => "cenault_03-2021"
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
