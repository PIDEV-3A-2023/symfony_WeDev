<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Station;
use App\Entity\Velo;

#[Route('/station')]
class StationController extends AbstractController
{
    #[Route('/', name: 'app_station')]
    public function station( ): Response
    { 
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();

        $bsekel=$this->getDoctrine()->getRepository(Velo::class)->findAll();
        return $this->render('reservation/station.html.twig', [
            'darajet' => $bsekel,
            'liss' => $messtation,
        ]);
    }
}
