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
            'nom' => 'Quilliou',
            'prenom' => 'Edouard',
            'login' => 'equilliou',
            'roles' => ['ROLE_VISITEUR'],
            'email' => 'equilliou@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adresse' => '40 av Barth',
            'ville' => 'paris',
            'codePostal' => '75015',
            'dateEmbauche' => '2019-09-01',
        ],
        [
            'nom' => 'Gest',
            'prenom' => 'Alain',
            'login' => 'agest',
            'roles' => ['ROLE_VISITEUR'],
            'email' => 'agest@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adresse' => '30 avenue de la mer',
            'ville' => 'Berre',
            'codePostal' => '13025',
            'dateEmbauche' => '1985-11-01',
        ],
        [
            'nom' => 'Frémont',
            'prenom' => 'Fernande',
            'login' => 'ffremont',
            'roles' => ['ROLE_VISITEUR'],
            'email' => 'ffremont@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adresse' => '4 route de la mer',
            'ville' => 'Allauh',
            'codePostal' => '13012',
            'dateEmbauche' => '1998-10-01',
        ],
        [
            'nom' => 'Groetschel',
            'prenom' => 'Jonas',
            'login' => 'jogroe',
            'roles' => ['ROLE_VISITEUR'],
            'email' => 'jogroe@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adresse' => '40 av Barth',
            'ville' => 'paris',
            'codePostal' => '75015',
            'dateEmbauche' => '2019-09-01',
        ],
        [
            'nom' => 'Baribaud ',
            'prenom' => 'Marc',
            'login' => 'devtest',
            'roles' => ['ROLE_VISITEUR'],
            'email' => 'm.baribaud@gsb.fr',
            'password' => '$argon2i$v=19$m=16,t=2,p=1$c1o0ZWI0ZkczalB5ODRKQg$q+DWOfcstsq5+NV9+apfpw',
            'adresse' => '6, Rue du Docteur Lombard',
            'ville' => 'Issy-les-Moulineaux',
            'codePostal' => '92130',
            'dateEmbauche' => '2019-09-01',
        ]
    ];
    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $user) {
            $entity = new User;
            $entity->setNom($user['nom']);
            $entity->setPrenom(($user['prenom']));
            $entity->setLogin($user['login']);
            $entity->setRoles($user['roles']);
            $entity->setEmail($user['email']);
            $entity->setPassword($user['password']);
            $entity->setAdresse($user['adresse']);
            $entity->setVille($user['ville']);
            $entity->setCodePostal($user['codePostal']);
            $entity->setDateEmbauche(new DateTime( $user['dateEmbauche']));

            $this->addReference($user['login'], $entity);
            
            $manager->persist($entity);
        }
        $manager->flush();
    }
}
