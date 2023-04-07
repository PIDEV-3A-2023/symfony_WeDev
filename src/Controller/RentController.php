<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends AbstractController
{
    #[Route('/', name: 'app_rent')]
    public function index(): Response
    {
        return $this->render('accueil.html.twig', [
            'controller_name' => 'RentController',
        ]);
    }
    
    #[Route('/velo', name: 'app_velo')]
    public function velo(): Response
    {
        return $this->render('velo/velo.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }
    
    #[Route('/station', name: 'app_station')]
    public function station(): Response
    {
        return $this->render('reservation/station.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }

    #[Route('/evenement', name: 'app_evenement')]
    public function evenement(): Response
    {
        return $this->render('evenement/evenement.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }

    #[Route('/reclamation', name: 'app_reclamation')]
    public function reclamation(): Response
    {
        return $this->render('reclamation/reclamation.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }
   
}
