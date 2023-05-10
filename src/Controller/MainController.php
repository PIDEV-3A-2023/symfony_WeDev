<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Station;
use App\Entity\ReservationVelo;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
            
        ]);
    } 
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(UserRepository $userRepository): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $r2=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $mesreservation = $r2->findAll();
        return $this->render('main/dashboard.html.twig', [
            'lissa' => $messtation,
            'lissr' => $mesreservation,
            'crepe' => $userRepository->find(35)
        ]);
    }
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $choklata=$this->getDoctrine()->getRepository(User::class);
        $crepe = $choklata->find(53);
        return $this->render('main/accueil.html.twig', [
            'crepe'=>$crepe
        ]);
    }
    #[Route('/welcom', name: 'welcom')]
    public function welcom(): Response
    {
        return $this->render('welcom.html.twig', [

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
