<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ReservationVelo;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationVeloType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation')]
    public function mesres(): Response
    {   $r=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation = $r->findAll();
        return $this->render('reservation/reservation.html.twig', [
            'messi' => $messtation,
        ]);
    }

    
}