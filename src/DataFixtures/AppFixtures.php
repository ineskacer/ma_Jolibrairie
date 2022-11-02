<?php

namespace App\DataFixtures;

use App\Entity\Amateur;
use App\Entity\Librairie;
use App\Repository\LibrairieRepository;
use App\Repository\AmateurRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use PharIo\Manifest\Library;

class AppFixtures extends Fixture
{

    /**
     * Generates initialization data for amateur [nom, description]
     * @return \\Generator
     */

     private static function amateursDataGenerator()
     {
        yield["Nesi", "Etudiante"];
     }

    /**
     * Generates initialization data for librarie : [description, amateur_nom, amateur_description]
     * @return \\Generator
     */
    private static function librairiesDataGenerator()
    {
        yield ["Mes livres préférés", "Nesi", "Etudiante"];
        yield ["A lire un jour de pluie", "Nesi", "Etudiante"];

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
        yield ["Bel Ami", 1885, "A lire un jour de pluie"];
     
    }

    public function load(ObjectManager $manager)
    {
        $amateurRepo = $manager->getRepository(Amateur::class);

        foreach (self::amateursDataGenerator() as [$amateur_nom, $amateur_description]) {
            $amateur = new Amateur();
            $amateur->setNom($amateur_nom);
            $amateur->setDescription($amateur_description);
            $manager->persist($amateur);
        }
        $manager->flush();


        $librairieRepo = $manager->getRepository(Librairie::class);

        foreach (self::librairiesDataGenerator() as [$description, $amateur_nom, $amateur_description] ) {
            $amateur = $amateurRepo->findOneBy(['nom' => $amateur_nom, 'description' => $amateur_description]);
            $librairie = new Librairie();
            $librairie->setDescription($description);
            $amateur->addLibrairie($librairie);
            $manager->persist($amateur);          
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


