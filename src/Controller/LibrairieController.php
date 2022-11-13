<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibrairieRepository;
use App\Entity\Librairie;
use Symfony\Component\HttpFoundation\Request;
use PharIo\Manifest\Library;
use App\Form\LibrairieType;
use App\Entity\Amateur;

class LibrairieController extends AbstractController
{

    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexAction()
    {
        return $this->render(
            'index.html.twig',
            ['welcome' => "J'espère que vous y trouverez votre nouveau bouquin préféré !"]
        );
    }

    /**
     * Lists all librairies entities.
     * @Route("/librairies", name="librairies_list", methods="GET")
     */
    public function list(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $librairies = $entityManager->getRepository(Librairie::class)->findAll();

        dump($librairies);

        return $this->render(
            'librairie/index.html.twig',
            ['librairies' => $librairies]
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
        return $this->render(
            'librairie/show.html.twig',
            ['librairie' => $librairie]
        );
    }

    #[Route('/new/{id}', name: 'librairie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LibrairieRepository $librairieRepository, Amateur $amateur): Response
    {

        $librairie = new Librairie();
        $librairie->setAmateur($amateur);
        $form = $this->createForm(LibrairieType::class, $librairie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $librairieRepository->save($librairie, true);
            $this->addFlash('message', 'création effectuée');

            return $this->redirectToRoute('librairies_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('librairie/new.html.twig', [
            'librairie' => $librairie,
            'form' => $form,
        ]);
    }

    #[Route('librairie/{id}/delete', name: 'app_librairie_delete', methods: ['POST'])]
    public function delete(Request $request, Librairie $librairie, LibrairieRepository $librairieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $librairie->getId(), $request->request->get('_token'))) {
            $librairieRepository->remove($librairie, true);
        }
        $this->addFlash('message', 'suppression effectuée');
        return $this->redirectToRoute('librairies_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('librairie/{id}/edit', name: 'app_librairie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Librairie $librairie, LibrairieRepository $librairieRepository): Response
    {
        $form = $this->createForm(LibrairieType::class, $librairie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $librairieRepository->save($librairie, true);

            $this->addFlash('message', 'Modification effectuée');
            return $this->redirectToRoute('librairies_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('librairie/edit.html.twig', [
            'librairie' => $librairie,
            'form' => $form,
        ]);
    }
}
