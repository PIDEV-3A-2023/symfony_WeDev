<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Entity\Station;
use App\Form\StationType;
use App\Repository\UserRepository;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ReservationVeloRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Exception\IntegrityConstraintViolationException;

#[Route('/station')]
class StationbController extends AbstractController
{


    ////////////////////////////////////////////////////
    #[Route('/b', name: 'app_stationb')]
    public function stationb(): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        return $this->render('reservation/stationb.html.twig', [
            'liss' => $messtation,'wael'=>'','siwael'=>''
        ]);
    }

    ///////////////////////////////////////////////

    #[Route('/', name: 'app_station')]
    public function station(UserRepository $userRepository ): Response
    { 
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();

        $bsekel=$this->getDoctrine()->getRepository(Velo::class)->findAll();
        return $this->render('reservation/station.html.twig', [
            'darajet' => $bsekel,
            'liss' => $messtation,
            'crepe' => $userRepository->find(37)
        ]);
    }

    #[Route('/add', name: 'app_addstation')]
    public function addstation(Request $request): Response
    {
        $station = new station();     
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isvalid()) {
            $station = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($station);
            $em->flush();
            return $this->redirectToRoute('app_stationb');}
        return $this->render('reservation/addstation.html.twig', [
            'formA' => $form->createView()
        ]);
    }
    #[Route('/{id}', name: 'app_delstation')]
    public function delStation($id, ManagerRegistry $doctrine, StationRepository $rep, ReservationVeloRepository $represervation): Response
    {          
        $r = $this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $station = $rep->find($id);
        $countreservation = count($represervation->findBy(['idStation' => $station->getIdStation()]));
        $wael = 'Impossible !!! (il existe des reservations dans cette station!)';
    
        if ($countreservation != 0) {
            return $this->render('reservation/stationb.html.twig', [
                'liss' => $messtation,
                'wael' => $wael,
                'siwael'=>''
            ]);
        }
    
        $entityManager = $doctrine->getManager();
        $entityManager->remove($station);
        $entityManager->flush(); 
        return $this->redirectToRoute('app_stationb', [
            'liss' => $messtation,
            'wael' => '',
            'siwael'=>'Station supprimer avec succe!'
        ]);
    }
       
    #[Route('/{id}/edit', name: 'app_modstation', methods: ['GET', 'POST'])]
    public function edit(Request $request, Station $Station, EntityManagerInterface $entityManager): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $form = $this->createForm(StationType::class, $Station);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stationb', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/modstation.html.twig', [
            'liss' => $messtation,
            'Station' => $Station,
            'formA' => $form,
        ]);
    }
}