<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Reserv;
use App\Entity\Booking;
use App\Entity\Station;
use App\Form\EventType;
use App\Form\StationType;
use App\Repository\UserRepository;
use App\Controller\ReservController;
use App\Repository\StationRepository;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\UrlPackage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\PathPackage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;


class FrontController extends AbstractController
{

#[Route('/evenement', name: 'app_evenement')]
public function evenement(Security $security ,UserRepository $userRepository): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $eventRepository = $entityManager->getRepository(Event::class);
    $events = $eventRepository->findAll();

    // Get the current user
    $user = $security->getUser();

    // Check if the user has made a reservation for each event
    $hasReservations = [];
    foreach ($events as $event) {
        $reservation = $this->getDoctrine()->getRepository(Reserv::class)->findOneBy([
            'idEvent' => $event->getIdEvent(),
           
        ]);
        $hasReservations[$event->getIdEvent()] = $reservation !== null;
    }

    // Render the view with the events and the "hasReservation" array
    return $this->render('evenement/evenement.html.twig', [
        'events' => $events,
        'hasReservations' => $hasReservations,
        'crepe' => $userRepository->find(53)
    ]);
}

}
