<?php

namespace App\Controller;

use App\Entity\ReservationVelo;
use App\Form\ReservationVeloType;
use App\Repository\ReservationVeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/{idReservation}/edit', name: 'app_reservation_velo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationVelo $reservationVelo, ReservationVeloRepository $reservationVeloRepository): Response
    {
        $form = $this->createForm(ReservationVeloType::class, $reservationVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationVeloRepository->save($reservationVelo, true);

            return $this->redirectToRoute('app_reservation_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_velo/edit.html.twig', [
            'reservation_velo' => $reservationVelo,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_velo_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationVelo $reservationVelo, ReservationVeloRepository $reservationVeloRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationVelo->getIdReservation(), $request->request->get('_token'))) {
            $reservationVeloRepository->remove($reservationVelo, true);
        }

        return $this->redirectToRoute('app_reservation_velo_index', [], Response::HTTP_SEE_OTHER);
    }
}
