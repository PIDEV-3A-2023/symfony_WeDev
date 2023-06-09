<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\ReservationVelo;
#[Route('/reservationb')]
class ReservationbController extends AbstractController
{
    #[Route('/', name: 'app_reservationb')]
    public function index(): Response
    {
        $r=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation = $r->findAll();
        return $this->render('reservation/reservationb.html.twig', [
            'liss' => $messtation,
        ]);
    }
}
