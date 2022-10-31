<?php

namespace App\DataFixtures;

use App\Entity\Librairie;
use App\Repository\LibrairieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use PharIo\Manifest\Library;

class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for librarie : [description]
     * @return \\Generator
     */
    private static function librairiesDataGenerator()
    {
        yield ["Mes livres préférés"];

    }

    /**
     * Generates initialization data for livres :
     *  [titre, annee_de_parution, librairie_description]
     * @return \\Generator
     */
    private static function livresDataGenerator()
    {
        yield ["Harry Potter à l'école des sorciers", 1997, "Mes livres préférés"];
        yield ["Harry Potter et la chambre des secrets", 1998, "Mes livres préférés"];
        yield ["Harry Potter et la coupe de feu", 2000, "Mes livres préférés"];
     
    }

    public function load(ObjectManager $manager)
    {
        $librairieRepo = $manager->getRepository(Librairie::class);

        foreach (self::librairiesDataGenerator() as [$description] ) {
            $librairie = new Librairie();
            $librairie->setDescription($description);
            $manager->persist($librairie);          
        }
        $manager->flush();

        foreach (self::livresDataGenerator() as [$titre, $annee_de_parution, $description])
        {
            $librairie = $librairieRepo->findOneBy(['description' => $description]);
            $livre = new Livre();
            $livre->setTitre($titre);
            $livre->setAnneeDeParution($annee_de_parution);
            $librairie->addLivre($livre);
            // there's a cascade persist on fim-recommendations which avoids persisting down the relation
            $manager->persist($librairie);
        }
        $manager->flush();
    }
}

