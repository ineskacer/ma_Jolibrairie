<?php

namespace App\DataFixtures;

use App\Entity\Amateur;
use App\Entity\Librairie;
use App\Repository\LibrairieRepository;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Repository\AmateurRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use App\Entity\User;
Use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use PharIo\Manifest\Library;



class AppFixtures extends Fixture implements DependentFixtureInterface

{
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
    /**
     * Generates initialization data for amateur [nom, description, usermail]
     * @return \\Generator
     */

    private static function amateursDataGenerator()
    {
        yield ["Inès", "Etudiante", "ineskacer@gmail.com"];
        yield ["Eden", "J'aime particulièrement les livres de vampires", "eden@gmail.com"];
        yield ["Jasmine", "Lycéene", "jasmine@gmail.com"];
        yield ["Ferroudja", "Je m'amuse à deviner la fin des thrillers", "ferroudja@gmail.com"];
        yield ["Arezki", "Je lis de tout !", "arezki@gmail.com"];
        yield ["Adam", "J'aime les livres sur l'océan et ceux sur le Moyen-Age", "adam@gmail.com"];
    }

    /**
     * Generates initialization data for librarie : [description, amateur_nom, amateur_description]
     * @return \\Generator
     */
    private static function librairiesDataGenerator()
    {
        yield ["Mes livres préférés", "Inès", "Etudiante"];
        yield ["A lire un jour de pluie", "Inès", "Etudiante"];
    }

    /**
     * Generates initialization data for genre : [intitule, amateur_nom, amateur_description]
     * @return \\Generator
     */
    private static function genresDataGenerator()
    {
        yield ["Fantastique", "Inès", "Etudiante"];
        yield ["Réalisme", "Inès", "Etudiante"];
        yield ["Littérature pour enfants", "Inès", "Etudiante"];
    }

    /**
     * Generates initialization data for livres :
     *  [titre, annee_de_parution, librairie_description, genre_intitule]
     * @return \\Generator
     */
    private static function livresDataGenerator()
    {
        yield ["Harry Potter à l'école des sorciers", 1997, "Mes livres préférés", "Fantastique"];
        yield ["Harry Potter et la chambre des secrets", 1998, "Mes livres préférés", "Fantastique"];
        yield ["Harry Potter et la coupe de feu", 2000, "Mes livres préférés", "Fantastique"];
        yield ["Bel Ami", 1885, "A lire un jour de pluie", "Réalisme"];
        yield ["Le Petit Prince", 1943, "A lire un jour de pluie", "Littérature pour enfants"];
    }

    public function load(ObjectManager $manager)

    {

        $amateurRepo = $manager->getRepository(Amateur::class);

        foreach (self::amateursDataGenerator() as [$amateur_nom, $amateur_description, $usermail]) {

            $amateur = new Amateur();
            if ($usermail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($usermail);
                $amateur->setUser($user);
            }
            $amateur->setNom($amateur_nom);
            $amateur->setDescription($amateur_description);
            $manager->persist($amateur);
        }
        $manager->flush();


        $librairieRepo = $manager->getRepository(Librairie::class);

        foreach (self::librairiesDataGenerator() as [$description, $amateur_nom, $amateur_description]) {
            $amateur = $amateurRepo->findOneBy(['nom' => $amateur_nom, 'description' => $amateur_description]);
            $librairie = new Librairie();
            $librairie->setDescription($description);
            $amateur->addLibrairie($librairie);
            $manager->persist($amateur);
        }
        $manager->flush();

        $genreRepo = $manager->getRepository(Genre::class);

        foreach (self::genresDataGenerator() as [$intitule, $amateur_nom, $amateur_description]) {
            $amateur = $amateurRepo->findOneBy(['nom' => $amateur_nom, 'description' => $amateur_description]);
            $genre = new Genre();
            $genre->setIntitule($intitule);
            $amateur->addGenre($genre);
            $manager->persist($amateur);
        }
        $manager->flush();

        foreach (self::livresDataGenerator() as [$titre, $annee_de_parution, $description, $intitule]) {
            $librairie = $librairieRepo->findOneBy(['description' => $description]);
            $genre = $genreRepo->findOneBY(['intitule' => $intitule]);
            $livre = new Livre();
            $livre->setTitre($titre);
            $livre->setAnneeDeParution($annee_de_parution);
            $librairie->addLivre($livre);
            $genre->addLivre($livre);
            // there's a cascade persist on fim-recommendations which avoids persisting down the relation
            $manager->persist($librairie);
            $manager->persist($genre);
        }
        $manager->flush();
    }
}
