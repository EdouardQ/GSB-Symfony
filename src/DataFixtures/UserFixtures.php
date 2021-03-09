<?php

namespace App\DataFixtures;

use App\Entity\User as EntityUser;
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
    ];
    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $ListUser) {
            $user = new EntityUser;
            $user->setNom($ListUser['nom']);
            $user->setPrenom(($ListUser['prenom']));
            $user->setLogin($ListUser['login']);
            $user->setRoles($ListUser['roles']);
            $user->setEmail($ListUser['email']);
            $user->setPassword($ListUser['password']);
            $user->setAdresse($ListUser['adresse']);
            $user->setVille($ListUser['ville']);
            $user->setCodePostal($ListUser['codePostal']);
            $user->setDateEmbauche(new DateTime( $ListUser['dateEmbauche']));

            $this->addReference($ListUser['login'], $user);
            
            $manager->persist($user);
        }
        $manager->flush();
    }
}
