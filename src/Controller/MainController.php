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
}
