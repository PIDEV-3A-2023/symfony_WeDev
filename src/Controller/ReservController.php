<?php

namespace App\Controller;

use App\Entity\Reserv;
use App\Form\ReservType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Endroid\QrCode\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use App\Entity\User;
use App\Entity\Reserv;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Endroid\QrCode\Factory\QrCodeFactory;


#[Route('/reserv')]
class ReservController extends AbstractController
{
    #[Route('/', name: 'app_reserv_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservs = $entityManager
            ->getRepository(Reserv::class)
            ->findAll();

        return $this->render('reserv/index.html.twig', [
            'reservs' => $reservs,
        ]);
    }

    #[Route('/new', name: 'app_reserv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reserv = new Reserv();
        $form = $this->createForm(ReservType::class, $reserv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reserv);
            $entityManager->flush();

            return $this->redirectToRoute('app_reserv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserv/new.html.twig', [
            'reserv' => $reserv,
            'form' => $form,
        ]);
    }

    #[Route('/{idRes}', name: 'app_reserv_show', methods: ['GET'])]
    public function show(Reserv $reserv): Response
    {
        return $this->render('reserv/show.html.twig', [
            'reserv' => $reserv,
        ]);
    }

    #[Route('/{idRes}/edit', name: 'app_reserv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reserv $reserv, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservType::class, $reserv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reserv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reserv/edit.html.twig', [
            'reserv' => $reserv,
            'form' => $form,
        ]);
    }

    #[Route('/{idRes}', name: 'app_reserv_delete', methods: ['POST'])]
    public function delete(Request $request, Reserv $reserv, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reserv->getIdRes(), $request->request->get('_token'))) {
            $entityManager->remove($reserv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reserv_index', [], Response::HTTP_SEE_OTHER);
    }

    


#[Route('/reserver/{idEvent}', name: 'app_event_reserver', methods: ['GET'])]
public function reserver(int $idEvent, EntityManagerInterface $entityManager): Response
{
  $iduser = 53; // Exemple : l'ID de l'utilisateur est 28
$user = $entityManager->getRepository(User::class)->find($iduser);
    $event = $entityManager->getRepository(Event::class)->find($idEvent);

    if (!$user) {
        return new JsonResponse(['success' => false, 'message' => 'L\'utilisateur n\'existe pas.']);
    }

    if (!$event) {
        throw $this->createNotFoundException('L\'événement n\'existe pas.');
    }

    if ($event->getDispoplaceEvent() == 0) {
        $this->addFlash('error', 'Désolé, il n\'y a plus de places disponibles Merci.');
        return $this->redirectToRoute('app_evenement', ['idEvent' => $event->getIdEvent()]);
    }

    $reserv = new Reserv();
    $reserv->setIdUser($user);
    $reserv->setIdEvent($event);
    $entityManager->persist($reserv);
    $entityManager->flush();

    $event->setDispoplaceEvent($event->getDispoplaceEvent() - 1);
    $entityManager->flush();
    
    $this->addFlash('success', 'Votre réservation a bien été enregistrée.');

    return $this->redirectToRoute('app_evenement', ['idEvent' => $event->getIdEvent()]);
}







}
