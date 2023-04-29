<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ReservationVelo;
use App\Entity\Station;

class MainController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            
        ]);
    }
    #[Route('/forgot', name: 'app_forgot')]
    public function forgot(): Response
    {
        $st=new Station();
        return $this->render('user/forgot.html.twig', [
            
        ]);
    }
    #[Route('/register1', name: 'app_register1')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
            
        ]);
    } 
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $r2=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $mesreservation = $r2->findAll();
        return $this->render('main/dashboard.html.twig', [
            'lissa' => $messtation,
            'lissr' => $mesreservation
        ]);
    }
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('main/accueil.html.twig', [

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
    

    #[Route('/reclamationb', name: 'app_reclamationb')]
    public function reclamationb(): Response
    {
        return $this->render('reclamation/reclamationb.html.twig', [

        ]);
    }

    #[Route('/profileb', name: 'app_profileb')]
    public function profileb(): Response
    {
        return $this->render('user/profileb.html.twig', [

        ]);
    }
}
