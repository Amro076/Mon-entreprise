<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) 
        { 
       
        $employe = new Employe;

        $employe->setPrenom("Prenom n°$i")
                ->setNom("Nom $i")
                ->setTelephone("$i")
                ->setEmail("E-mail $i")
                ->setAdresse("Adresse $i")
                ->setPoste("Poste $i")
                ->setSalaire(" $i")
                ->setDatedenaissance("$i");


        $manager->persist($employe);    
            
        }

        $manager->flush();
    }
}
