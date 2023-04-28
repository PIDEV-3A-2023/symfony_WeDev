<?php


namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Factory\QrCodeFactory;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\Image\Png as BaconQrCodePng;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\PngImageBackEnd;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;


use App\Repository\EventRepository;
use Twig\Environment;



#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager
            ->getRepository(Event::class)
            ->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }





#[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $event = new Event();
    $form = $this->createForm(EventType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $photoFile = $form->get('photoEvent')->getData();

        if ($photoFile) {
            $newFilename = uniqid().'.'.$photoFile->guessExtension();
            $photoFile->move(
                $this->getParameter('event_photo_directory'),
                $newFilename
            );
            $event->setPhotoEvent($newFilename);
        }

        $entityManager->persist($event);
        $entityManager->flush();

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('event/new.html.twig', [
        'event' => $event,
        'form' => $form,
    ]);
}


    #[Route('/{idEvent}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{idEvent}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
              $photoFile = $form->get('photoEvent')->getData();
               if ($photoFile) {
            $newFilename = uniqid().'.'.$photoFile->guessExtension();
            $photoFile->move(
                $this->getParameter('event_photo_directory'),
                $newFilename
            );
            $event->setPhotoEvent($newFilename);
        }

            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{idEvent}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getIdEvent(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }


#[Route('/event/search', name: 'app_event_search', methods: ['POST'])]
public function search(Request $request)
{
    $niveau = $request->request->get('niveau');

    $events = $this->getDoctrine()
        ->getRepository(Event::class)
        ->createQueryBuilder('e')
        ->where('e.nomEvent LIKE :nom')
        ->setParameter('nom', '%'.$niveau.'%')
        ->getQuery()
        ->getResult();

    return $this->render('event/recherche.html.twig', [
        'events' => $events,
    ]);
}


#[Route('/event/tri', name: 'app_event_tri', methods: ['POST'])]
public function tri(Request $request)
{
    // Get the EntityManager
    $em = $this->getDoctrine()->getManager();

    // Create a query builder for the Event entity
    $qb = $em->createQueryBuilder();
    $qb->select('e')
        ->from(Event::class, 'e');

    // Get the order parameter from the form
    $order = $request->request->get('sort');

    // Add the order by clause to the query builder
    if ($order == 'ASC') {
        $qb->orderBy('e.dateEvent', 'ASC');
    } else {
        $qb->orderBy('e.dateEvent', 'DESC');
    }

    // Get the sorted events
    $events = $qb->getQuery()->getResult();

    // Render the view
    return $this->render('event/index.html.twig', [
        'events' => $events,
    ]);
}



 #[Route('/event/pdf', name: 'app_event_pdf', methods: ['GET'])]
    public function pdf(EntityManagerInterface $entityManager)
    {
        // Get the events from the repository
        $events = $entityManager
            ->getRepository(Event::class)
            ->findAll();

        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        // Instantiate Dompdf
        $dompdf = new Dompdf($options);

        // Generate the PDF
        $html = $this->renderView('event/index.html.twig', [
            'events' => $events,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate the response
        $response = new Response();
        $response->setContent($dompdf->output());
       // Set the filename
$filename = 'events.pdf';

// Set the Content-Disposition header to force download
$response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

return $response;

    }

 #[Route('/{idEvent}', name: 'event_show', methods: ['GET'])]
    public function showQrCode(Event $event, Request $request, EntityManagerInterface $entityManager): Response
{
    // Check if the user has made a reservation for this event
    $reservation = $entityManager->getRepository(Reservation::class)->findOneBy([
        'user' => $this->getUser(),
        'event' => $event,
    ]);

    // Render the view with the "Code QR" button if the user has made a reservation
    return $this->render('event/show.html.twig', [
        'event' => $event,
        'hasReservation' => $reservation !== null,
    ]);
}







}
