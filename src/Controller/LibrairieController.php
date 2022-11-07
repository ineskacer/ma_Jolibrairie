<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Librairie;
use PharIo\Manifest\Library;

class LibrairieController extends AbstractController
{

    /**
 * @Route("/", name = "home", methods="GET")
 */
    public function indexAction()
    {
        return $this->render('index.html.twig',
            [ 'welcome' => "J'espère que vous y trouverez votre nouveau bouquin préféré !" ]
        );
    }

    /**
     * Lists all librairies entities.
     * @Route("/librairies", name="librairies_list", methods="GET")
     */
    public function list(ManagerRegistry $doctrine)
    {
        $entityManager= $doctrine->getManager();
        $librairies = $entityManager->getRepository(Librairie::class)->findAll();
    
        dump($librairies);
    
        return $this->render('librairie/index.html.twig',
            [ 'librairies' => $librairies ]
            );
    }  

    /**
     * Show a librairie
     * 
     * @Route("/librairie/{id}", name="librairie_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     * @param Integer $id
     */

    public function show(Librairie $librairie): Response
    {
        return $this->render('librairie/show.html.twig',
        [ 'librairie' => $librairie ]
        );
    }

}