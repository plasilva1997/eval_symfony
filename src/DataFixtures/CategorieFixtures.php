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


        //php bin/console d:f:l
        $categorie = new Categorie();
        $categorie->setNom("Action");
        $manager->persist($categorie);

        $one = new Film();
        $one->setNom("Starwars");
        $one->setCategorieId($categorie);
        $manager->persist($one);

        $acteur = new Acteur();
        $acteur->setNom("Harrison Ford");
        $acteur->addFilmId($one);
        $manager->persist($acteur);






        $manager->flush();
    }
}
