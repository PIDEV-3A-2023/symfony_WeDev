<?php

namespace App\Controller;

use App\Entity\ReservationVelo;
use App\Form\ReservationVelo1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation/velo')]
class ReservationVeloController extends AbstractController
{
    #[Route('/', name: 'app_reservation_velo_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservationVelos = $entityManager
            ->getRepository(ReservationVelo::class)
            ->findAll();

        return $this->render('reservation_velo/index.html.twig', [
            'reservation_velos' => $reservationVelos,
        ]);
    }

    #[Route('/new', name: 'app_reservation_velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservationVelo = new ReservationVelo();
        $form = $this->createForm(ReservationVelo1Type::class, $reservationVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationVelo);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_velo/new.html.twig', [
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
    public function edit(Request $request, ReservationVelo $reservationVelo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationVelo1Type::class, $reservationVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_velo/edit.html.twig', [
            'reservation_velo' => $reservationVelo,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_velo_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationVelo $reservationVelo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationVelo->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservationVelo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_velo_index', [], Response::HTTP_SEE_OTHER);
    }
}
