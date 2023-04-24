<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Station;
use App\Entity\Velo;
use App\Repository\StationRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StationType;



class FrontController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('main/accueil.html.twig', [

        ]);
    }
    
    #[Route('/velo1', name: 'app_velo')]
    public function velo(): Response
    {$r=$this->getDoctrine()->getRepository(Velo::class);
        $mesvelos = $r->findAll();

        return $this->render('velo1/velo1.html.twig', [

            'v' => $mesvelos,

        ]);
    }
    
    #[Route('/station', name: 'app_station')]
    public function station( ): Response
    { 
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();

        return $this->render('reservation/station.html.twig', [

            'liss' => $messtation,
        ]);
    }

    #[Route('/evenement', name: 'app_evenement')]
    public function evenement(): Response
    {
        return $this->render('evenement/evenement.html.twig', [

        ]);
    }

    #[Route('/reclamation', name: 'app_reclamation')]
    public function reclamation(): Response
    {
        return $this->render('reclamation/reclamation.html.twig', [

        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig', [

        ]);
    }
}
