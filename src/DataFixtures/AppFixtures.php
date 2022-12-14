<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Articles;
use App\Entity\User;
use App\Entity\Baniere;
use App\Entity\Categories;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //$i=1;
        for($i=3; $i<15; ++$i)
           {
                $Categories = new Categories();
                $Baniere    = new Baniere();
                $Articles   = new Articles();
                $User       = new User();
                $User       ->setEmail('d'.$i.'@gmail.com')
                            ->setRoles(['Role_admin'])
                            ->setPassword('Motdepasse')
                            ->setAdresse(['Adresse1' =>'Mon adresse']);
                //setArticles()
        
                

                $Articles   ->setTitre('Titre'.$i)
                            ->setBaniereUrl('/assets/falcon.png')
                            ->setContent('Content'.$i)
                            ->setPublie(false)
                            ->setAutheur($User);

                $Baniere    ->setTitre('Titre'.$i)
                            ->setImageUrl("/assets/download.jpg");

                $Categories ->setTitre('Titre'.$i)
                            ->setCouleur("#1".$i."3456")
                            ->setArticles($Articles);

                $manager->persist($User);
                $manager->persist($Categories);
                $manager->persist($Baniere);
                $manager->persist($Articles);
                $manager->flush();
            }
    }
}
