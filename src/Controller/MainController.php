<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('main/dashboard.html.twig', [
            
        ]);
    }
    
}
