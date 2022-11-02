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
    #[Route('/', name: 'app_librairie')]

    /**
     * Lists all librairies entities.
     * @Route("/", name="librairies_list", methods="GET")
     */
    public function list(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mes Jolibrairies!</title>
    </head>
    <body>
        <h1>Mes Jolibrairies</h1>
        <p>Voici toutes mes Jolibrairies:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $librairies = $entityManager->getRepository(Librairie::class)->findAll();
        foreach($librairies as $librairie) {
           $htmlpage .= '<li>
            <a href="/librairie/'.$librairie->getid().'">'.$librairie->getDescription().'</a></li>';
         }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
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

    public function show(ManagerRegistry $doctrine, $id)
    {
        $librairieRepo = $doctrine->getRepository(Librairie::class);
        $librairie = $librairieRepo->find($id);

        if (!$librairie) {
            throw $this->createNotFoundException('Cette Jolibrairie est encore dans votre imaginaire');
        }

        $res = '<!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title> Jolibrairie n° '.$librairie->getId().'</title>
            </head>
            <body>
                <h2>Détails:</h2>
                <ul>
                <dl>';
                
                $res .= '<dt><h4><strong>Jolibrairie n° '.$librairie->getId().' : </h4></strong></dt><dd>' . $librairie->getDescription() . '</dd>';
                $res .= '</dl>';
                $res .= '<p/><a href="' . $this->generateUrl('librairies_list') . '"><strong>Retour</strong></a>';
                $res .= '</ul></body></html>';

                

        return new Response('<html><body>'. $res . '</body></html>');
}


}