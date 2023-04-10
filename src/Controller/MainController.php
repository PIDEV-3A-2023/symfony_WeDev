<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    #[Route('/register', name: 'app_register')]
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
        return $this->render('main/dashboard.html.twig', [
            'lissa' => $messtation,
        ]);
    }
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('main/accueil.html.twig', [

        ]);
    }
    
    #[Route('/velo', name: 'app_velo')]
    public function velo(): Response
    {
        return $this->render('velo/velo.html.twig', [

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
    #[Route('/velob', name: 'app_velob')]
    public function velob(): Response
    {
        return $this->render('velo/velob.html.twig', [

        ]);
    }
    
    

    #[Route('/evenementb', name: 'app_evenementb')]
    public function evenementb(): Response
    {
        return $this->render('evenement/evenementb.html.twig', [

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
