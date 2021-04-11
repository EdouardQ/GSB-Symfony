<?php

namespace App\DataFixtures;

use App\Entity\Medication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicationFixtures extends Fixture
{
    private array $list = [
        [
            'code' => '3MYC7',
            'name' => 'TRYMICINE',
            'family' => "Corticoïde, antibiotique et antifongique à usage local",
            'composition' => "Triamcinolone (acétonide) + Néomycine + Nystatine",
            'sideEffects' => "Ce médicament est un corticoïde à activité forte ou très forte associé à un antibiotique et un antifongique, utilisé en application locale dans certaines atteintes cutanées surinfectées.",
            'contraindications' => "Ce médicament est contre-indiqué en cas d'allergie à l'un des constituants, d'infections de la peau ou de parasitime non traités, d'acné. Ne pas appliquer sur une plaie, ni sous un pansement occlusif." 
        ],
        [
            'code' => 'ADIMOL9',
            'name' => 'ADIMOL',
            'family' => "Antibiotique de lafamille des béta—lactamines (pènicilline)",
            'composition' => 'Amoxicilline + Acide clavulanique',
            'sideEffects' => "Ce médicament plus puissant que les pénicillines simples, est utisé pour traîter des infections bactériennes spécifiques.",
            'contraindications' => "Ce médicament est contre-indiquè en cas d'allergie aux
                pénicillines ou aux céphalosporines.",
        ],
        [
            'code' => 'AMOPIL7',
            'name' => 'AMOPIL',
            'family' => "Antibiotique de lafamille des béta—lactamines (pènicilline)",
            'composition' => 'Amoxicilline',
            'sideEffects' => "Ce médicament plus puissant que les pénicillines simples, est a utilisé pour traiter des infections bactériennes spécifiques.",
            'contraindications' => "Ce médicament est contre-indiqué en cas d'allergie aux pènicillines. Il doit être administré avec prudence en cas d'allergie aux céphalosporines.",
        ],
        [
            'code' => 'DORNOMB',
            'name' => 'NORMADOR',
            'family' => "Hypnotique antihistaminique",
            'composition' => 'Doxylamine',
            'sideEffects' => "Ce médicament est utilisé pourtraîter l'insomnie chez l'adulte.",
            'contraindications' => "Ce médicament est contre—indiqué en cas de glaucome, de certains troubles urinaires (rétention urinaire) et chez l'enfant de — moins de 15 ans",
        ],
    ];
    

    public function load(ObjectManager $manager)
    {
        foreach ($this->list as $medication) {
            $entity = new Medication;

            $entity->setCode($medication['code']);
            $entity->setName($medication['name']);
            $entity->setFamily($medication['family']);
            $entity->setComposition($medication['composition']);
            $entity->setSideEffects($medication['sideEffects']);
            $entity->setContraindications($medication['contraindications']);

            $this->addReference($medication['name'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
