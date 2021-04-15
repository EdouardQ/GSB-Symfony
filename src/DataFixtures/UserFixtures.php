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
            'name' => 'dev ',
            'firstName' => 'admin',
            'login' => 'devadmin',
            'roles' => ['ROLE_ADMIN'],
            'email' => 'dev@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => 'dev',
            'city' => 'dev',
            'postalCode' => '77777',
            'hiringDate' => '2019-09-01',
            'enabled' => true,
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
            'enabled' => true,
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
            'enabled' => true,
        ],
        [
            'name' => 'Debelle',
            'firstName' => 'Jeanne',
            'login' => 'jdebelle',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'jdebelle@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '134 allée des Joncs',
            'city' => 'Nantes',
            'postalCode' => '44000',
            'hiringDate' => '2000-05-11',
            'enabled' => true,
        ],
        [
            'name' => 'Enault-Pascreau',
            'firstName' => 'Céline',
            'login' => 'cenault',
            'roles' => ['ROLE_VISITOR'],
            'email' => 'cenault@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '25 place de la gare',
            'city' => 'Gueret',
            'postalCode' => '23200',
            'hiringDate' => '1995-09-01',
            'enabled' => true,
        ],
        [
            'name' => 'Bioret',
            'firstName' => 'Luc',
            'login' => 'lbioret',
            'roles' => ['ROLE_ACCOUNTANT'],
            'email' => 'lbioret@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adress' => '1 Avenue gambetta',
            'city' => 'Cahors',
            'postalCode' => '46000',
            'hiringDate' => '1998-05-11',
            'enabled' => true,
        ],
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
            $entity->setEnabled($user['enabled']);

            $this->addReference($user['login'], $entity);
            
            $manager->persist($entity);
        }
        $manager->flush();
    }
}
