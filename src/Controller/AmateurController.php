<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Amateur;
use PharIo\Manifest\Library;

class AmateurController extends AbstractController
{
    /**
     * Lists all amateurs entities.
     * @Route("/amateurs", name="amateurs_list", methods="GET")
     */
    public function list(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $amateurs = $entityManager->getRepository(Amateur::class)->findAll();

        dump($amateurs);

        return $this->render(
            'amateur/index.html.twig',
            ['amateurs' => $amateurs]
        );
    }


    /**
     * Show an amateur
     * 
     * @Route("/amateur/{id}", name="amateur_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *    
     * @param Integer $id
     */

    public function show(Amateur $amateur): Response
    {
        $current_amateur = $this->getUser()->getAmateur();
        if ($amateur == $current_amateur) {
            return $this->render(
                'amateur/show.html.twig',
                ['amateur' => $amateur]
            );
        } elseif ($this->isGranted('ROLE_ADMIN')) {
            return $this->render(
                'amateur/admin.html.twig',
                ['amateur' => $amateur]
            );
        } else {
            return $this->render(
                'amateur/profil.html.twig',
                ['amateur' => $amateur]
            );
        }
    }
}
