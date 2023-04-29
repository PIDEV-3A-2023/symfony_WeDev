<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Station;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\StationRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StationType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\UrlPackage;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;







use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\User;
use App\Entity\Reserv;

use App\Entity\Booking;
use App\Controller\ReservController;
use Symfony\Component\Security\Core\Security;











class FrontController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('main/accueil.html.twig', [

        ]);
    }
    



#[Route('/evenement', name: 'app_evenement')]
public function evenement(Security $security): Response
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
    ]);
}

}
