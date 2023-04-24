<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserType;
use App\Entity\User;

class HassenController extends AbstractController
{
    #[Route('/hassen', name: 'app_hassen')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HassenController.php',
        ]);
    }
    #[Route('/houssem', name: 'app_houssem')]
    public function houssem(Request $request):Response
    {
    $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        return $this->render('templates/base.html.twig', [ 
            'form' => $form->createView(),
        ]);
    }
    
}
