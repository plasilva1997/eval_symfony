<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Film;
use App\Entity\Acteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $acteur = new Acteur();
        $categorie = new Categorie();
        //php bin/console d:f:l

        $categorie->setNom("Action");
        $manager->persist($categorie);

        for ($i = 1; $i < 8; $i++){
            $one = new Film();
            $one->setNom("Starwars $i");
            $one->setCategorieId($categorie);
            $manager->persist($one);
        }

        for ($i = 1; $i < 5; $i++){
            $one1 = new Film();
            $one1->setNom("Indiana Jones $i");
            $one1->setCategorieId($categorie);
            $manager->persist($one1);
        }


        $acteur->setNom("Harrison Ford");
        $acteur->addFilmId($one);
        $manager->persist($acteur);






        $manager->flush();
    }
}
