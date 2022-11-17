<?php

namespace App\Controller;

use App\Entity\Amateur;
use App\Entity\Etalage;
use App\Form\EtalageType;
use App\Repository\EtalageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;

#[Route('/etalage')]
class EtalageController extends AbstractController
{
    #[Route('/', name: 'app_etalage_index', methods: ['GET'])]
    public function index(EtalageRepository $etalageRepository): Response
    {
        $privateEtalage = array();
        $publicEtalage = array();
        $user = $this->getUser();
        if ($user) {
            $amateur = $user->getAmateur();
            $privateEtalage = $etalageRepository->findBy(
                [
                    'amateur' => $amateur,
                    'publie'  => false
                ]
            );
        }
        $publicEtalage = $etalageRepository->findBy(
            [
                'publie' => true
            ]
        );

        $etalage = array_merge($privateEtalage, $publicEtalage);

        return $this->render('etalage/index.html.twig', [
            'etalages' => $etalage
        ]);
    }

    #[Route('/new/{id}', name: 'app_etalage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtalageRepository $etalageRepository, Amateur $amateur): Response
    {
        $etalage = new Etalage();
        $etalage->setAmateur($amateur);
        $form = $this->createForm(EtalageType::class, $etalage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etalageRepository->save($etalage, true);
            $this->addFlash('message', 'Création effectuée');

            return $this->redirectToRoute('app_etalage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etalage/new.html.twig', [
            'etalage' => $etalage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etalage_show', methods: ['GET'])]
    public function show(Etalage $etalage): Response
    {
        return $this->render('etalage/show.html.twig', [
            'etalage' => $etalage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etalage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etalage $etalage, EtalageRepository $etalageRepository): Response
    {
        $form = $this->createForm(EtalageType::class, $etalage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etalageRepository->save($etalage, true);

            $this->addFlash('message', 'modification effectuée');
            return $this->redirectToRoute('app_etalage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etalage/edit.html.twig', [
            'etalage' => $etalage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etalage_delete', methods: ['POST'])]
    public function delete(Request $request, Etalage $etalage, EtalageRepository $etalageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etalage->getId(), $request->request->get('_token'))) {
            $etalageRepository->remove($etalage, true);
        }
        $this->addFlash('message', 'Suppression effectuée');
        return $this->redirectToRoute('app_etalage_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{etalage_id}/livre/{livre_id}", name="app_etalage_livre_show", methods={"GET"})
     * @ParamConverter("etalage", options={"id" = "etalage_id"})
     * @ParamConverter("livre", options={"id" = "livre_id"})
     */
    public function livreShow(Etalage $etalage, Livre $livre): Response
    {
        if (!$etalage->getLivres()->contains($livre)) {
            throw $this->createNotFoundException("Ce livre ne se trouve pas dans cet étalage !");
        }
        return $this->render('etalage/livre_show.html.twig', [
            'livre' => $livre,
            'etalage' => $etalage
        ]);
    }
}
