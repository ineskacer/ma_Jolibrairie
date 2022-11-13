<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Livre;
use App\Entity\Librairie;
use PharIo\Manifest\Library;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LivreRepository;
use App\Form\LivreType;

class LivreController extends AbstractController
{
    /**
     * Show livres from librairie
     * 
     * @Route("/livres", name="livres_list", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     */


    public function list(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $livres = $entityManager->getRepository(Livre::class)->findAll();

        dump($livres);

        return $this->render(
            'livre/index.html.twig',
            ['livres' => $livres]
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
        return $this->render(
            'livre/show.html.twig',
            ['livre' => $livre]
        );
    }

    #[Route('livre/new/{id}', name: 'livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LivreRepository $livreRepository, Librairie $librairie): Response
    {
        $livre = new Livre();
        $livre->setLibrairie($librairie);
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->save($livre, true);
            $this->addFlash('message', 'création effectuée');

            return $this->redirectToRoute('livres_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('livre/{id}/delete', name: 'app_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->request->get('_token'))) {
            $livreRepository->remove($livre, true);
        }
        $this->addFlash('message', 'Suppression effectuée');
        return $this->redirectToRoute('livres_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('livre/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->save($livre, true);

            $this->addFlash('message', 'modification effectuée');
            return $this->redirectToRoute('livres_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }
}
