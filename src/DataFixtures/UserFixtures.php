<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $list = [
        [
            'name' => 'Quilliou',
            'firstName' => 'Edouard',
            'login' => 'equilliou',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'equilliou@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '40 av Barth',
            'city' => 'paris',
            'postalCode' => '75015',
            'hiringDate' => '2019-09-01',
        ],
        [
            'name' => 'Gest',
            'firstName' => 'Alain',
            'login' => 'agest',
            'roles' => ['ROLE_ACCOUNTANT'],
            'email' => 'agest@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '30 avenue de la mer',
            'city' => 'Berre',
            'postalCode' => '13025',
            'hiringDate' => '1985-11-01',
        ],
        [
            'name' => 'Frémont',
            'firstName' => 'Fernande',
            'login' => 'ffremont',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'ffremont@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '4 route de la mer',
            'city' => 'Allauh',
            'postalCode' => '13012',
            'hiringDate' => '1998-10-01',
        ],
        [
            'name' => 'Groetschel',
            'firstName' => 'Jonas',
            'login' => 'jogroe',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'jogroe@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '40 av Barth',
            'city' => 'paris',
            'postalCode' => '75015',
            'hiringDate' => '2019-09-01',
        ],
        [
            'name' => 'Baribaud ',
            'firstName' => 'Marc',
            'login' => 'devtest',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'm.baribaud@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '6, Rue du Docteur Lombard',
            'city' => 'Issy-les-Moulineaux',
            'postalCode' => '92130',
            'hiringDate' => '2019-09-01',
        ]
    ];
    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $user) {
            $entity = new User;
            $entity->setName($user['name']);
            $entity->setFirstName(($user['firstName']));
            $entity->setLogin($user['login']);
            $entity->setRoles($user['roles']);
            $entity->setEmail($user['email']);
            $entity->setPassword($user['password']);
            $entity->setAdress($user['adress']);
            $entity->setCity($user['city']);
            $entity->setPostalCode($user['postalCode']);
            $entity->setHiringDate(new DateTime( $user['hiringDate']));

            $this->addReference($user['login'], $entity);
            
            $manager->persist($entity);
        }
        $manager->flush();
    }
}
