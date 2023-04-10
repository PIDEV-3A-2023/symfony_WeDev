<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\StationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Station;
use App\Repository\StationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/stationb')]
class StationbController extends AbstractController
{
    #[Route('/', name: 'app_stationb')]
    public function stationb(): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        return $this->render('reservation/stationb.html.twig', [
            'liss' => $messtation,
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
    public function dellstation($id,ManagerRegistry $doctrine,StationRepository $rep): Response
    {          
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
      
        $station=$rep->find($id);
            $entityManager=$doctrine->getManager();
            $entityManager->remove($station);
            $entityManager->flush(); 
            return $this->redirectToRoute('app_stationb',['liss' => $messtation]);
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