<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Genre;
use PharIo\Manifest\Library;

class GenreController extends AbstractController
{

    /**
     * Lists all genres entities.
     * @Route("/genres", name="genres_list", methods="GET")
     */
    public function list(ManagerRegistry $doctrine)
    {
        $entityManager= $doctrine->getManager();
        $genres = $entityManager->getRepository(Genre::class)->findAll();
    
        dump($genres);
    
        return $this->render('genre/index.html.twig',
            [ 'genres' => $genres ]
            );
    } 
    
        /**
     * Show a genre
     * 
     * @Route("/genre/{id}", name="genre_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     * @param Integer $id
     */

    public function show(Genre $genre): Response
    {
        return $this->render('genre/show.html.twig',
        [ 'genre' => $genre ]
        );
    }



}