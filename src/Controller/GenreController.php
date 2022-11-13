<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Genre;
use PharIo\Manifest\Library;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('genre/new', name: 'genre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenreRepository $genreRepository): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreRepository->save($genre, true);
            $this->addFlash('message', 'création effectuée');

            return $this->redirectToRoute('genres_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }
    #[Route('genre/{id}/edit', name: 'app_genre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Genre $genre, GenreRepository $genreRepository): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreRepository->save($genre, true);

            $this->addFlash('message', 'Modification effectuée');
            return $this->redirectToRoute('genres_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }


    #[Route('genre/{id}/delete', name: 'app_genre_delete', methods: ['POST'])]
    public function delete(Request $request, Genre $genre, GenreRepository $genreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $genre->getId(), $request->request->get('_token'))) {
            $genreRepository->remove($genre, true);
        }
        $this->addFlash('message', 'Suppression effectuée');
        return $this->redirectToRoute('genres_list', [], Response::HTTP_SEE_OTHER);
    }


}