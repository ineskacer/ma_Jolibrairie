<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
Use App\Entity\Livre;
use App\Entity\Librairie;
use PharIo\Manifest\Library;

class LivreController extends AbstractController
{
    #[Route('/livres', name: 'app_livre')]
    /**
     * Show livres from librairie
     * 
     * @Route("/livres", name="livres_list", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     */


    public function list(ManagerRegistry $doctrine)
    {
        $entityManager= $doctrine->getManager();
        $livres = $entityManager->getRepository(Livre::class)->findAll();
    
        dump($livres);
    
        return $this->render('livre/index.html.twig',
            [ 'livres' => $livres ]
            );
    }

    /**
     * Show a livre
     * 
     * @Route("/livres/{id}", name="livre_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     * @param Integer $id
     */

    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig',
        [ 'livre' => $livre ]
        );
    }
}
