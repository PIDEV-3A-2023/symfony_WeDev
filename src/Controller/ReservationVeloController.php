<?php

namespace App\Controller;

use App\Entity\ReservationVelo;
use App\Form\ReservationVeloType;
use App\Repository\ReservationVeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

#[Route('/reservation/velo')]
class ReservationVeloController extends AbstractController
{
   

    #[Route('/add', name: 'app_reservation_velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationVeloRepository $reservationVeloRepository): Response
    {
        $reservationVelo = new ReservationVelo();
        $form = $this->createForm(ReservationVeloType::class, $reservationVelo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationVeloRepository->save($reservationVelo, true);

            return $this->redirectToRoute('app_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/addreservation.html.twig', [
            'reservation_velo' => $reservationVelo,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_velo_show', methods: ['GET'])]
    public function show(ReservationVelo $reservationVelo): Response
    {
        return $this->render('reservation_velo/show.html.twig', [
            'reservation_velo' => $reservationVelo,
        ]);
    }


    // #[Route('/{idReservation}', name: 'app_reservation_velo_delete', methods: ['POST'])]
    // public function delete(Request $request, ReservationVelo $reservationVelo, ReservationVeloRepository $reservationVeloRepository): Response
    // {
    //     $r=$this->getDoctrine()->getRepository(ReservationVelo::class);
    //     $messtation = $r->findAll();
    //     if ($this->isCsrfTokenValid('delete'.$reservationVelo->getIdReservation(), $request->request->get('_token'))) {
    //         $reservationVeloRepository->remove($reservationVelo, true);
    //     }

    //     return $this->redirectToRoute('app_reservation', [ 'messi' => $messtation,], Response::HTTP_SEE_OTHER);
    // }

    #[Route('/{idReservation}', name: 'app_reservation_velo_delete')]
    public function delecteC($idReservation, ReservationVeloRepository $rep, 
    ManagerRegistry $doctrine): Response
    {
        //récupérer la classe à supprimer
        $reservation=$rep->find($idReservation);
        //Action de suppression
        //récupérer l'Entitye manager
        $em=$doctrine->getManager();
        $em->remove($reservation);
        //La maj au niveau de la bd
        $em->flush();
        return $this->redirectToRoute('app_reservation');
    }

 
}