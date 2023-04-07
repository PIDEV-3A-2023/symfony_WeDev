<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Station;

class BackController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        return $this->render('main/dashboard.html.twig', [
            'liss' => $messtation,
        ]);
    }

    #[Route('/velob', name: 'app_velob')]
    public function velob(): Response
    {
        return $this->render('velo/velo.html.twig', [

        ]);
    }
    
    #[Route('/stationb', name: 'app_stationb')]
    public function stationb(): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        return $this->render('reservation/stationback.html.twig', [
            'liss' => $messtation,
        ]);
    }

    #[Route('/evenementb', name: 'app_evenementb')]
    public function evenementb(): Response
    {
        return $this->render('evenement/evenement.html.twig', [

        ]);
    }

    #[Route('/reclamationb', name: 'app_reclamationb')]
    public function reclamationb(): Response
    {
        return $this->render('reclamation/reclamation.html.twig', [

        ]);
    }

    #[Route('/profileb', name: 'app_profileb')]
    public function profileb(): Response
    {
        return $this->render('user/profile.html.twig', [

        ]);
    }
}
