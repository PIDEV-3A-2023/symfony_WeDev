<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;

#[Route('/med')]
class MedController extends AbstractController
{

#[Route('/qr-code/{idEvent}', name: 'app_event_qr_code')]
  public function qrcode(int $idEvent, ManagerRegistry $managerRegistry): JsonResponse
    {
        $event = $managerRegistry->getRepository(Event::class)->find($idEvent);


      
if (!$event) {
    throw $this->createNotFoundException('L\'événement n\'existe pas.');
}

$qrCodeContent = sprintf(
    'Nom de l\'événement : %s, Date : %s, Lieu : %s',
    $event->getNomEvent(),
    $event->getDateEvent()->format('d/m/Y'),
    $event->getLocateEvent()
);

$qrCode = new QrCode($qrCodeContent);
$qrCode->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(120)
    ->setMargin(0)
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

$label = Label::create('')->setFont(new NotoSans(8));

$writer = new PngWriter();

$qrCodeDataUri = $writer->write($qrCode, null, $label->setText($event->getNomEvent())->setFont(new NotoSans(20)))->getDataUri();

$data = [
    'qrCodeDataUri' => $qrCodeDataUri,
    'event' => [
        'id' => $event->getId(),
        'nomEvent' => $event->getNomEvent(),
        'dateEvent' => $event->getDateEvent()->format('Y-m-d'),
        'locateEvent' => $event->getLocateEvent(),
    ],
];

return new JsonResponse($data);

    }


    #[Route('/add', name: 'add')]
 public function addEvent(Request $req, NormalizerInterface $normalizer): JsonResponse
{
   $em=$this->getDoctrine()->getManager();
   $event= new Event();
   $event->setNomEvent($req->get('nomEvent'));
   $event->setLocateEvent($req->get('locateEvent'));

   $event->setPhotoEvent($req->get('photoEvent'));
   $event->setDispoplaceEvent($req->get('dispoplaceEvent'));

   $em->persist($event);
   $em->flush();

   $jsonContent = $normalizer->normalize($event, 'json', ['groups' => 'events']);
   return new JsonResponse($jsonContent);
}

#[Route('/get', name: 'azeex')]
    public function index(NormalizerInterface $normalizer): Response
    {
        $event = $this->getDoctrine() ->getRepository(Event::class)->findAll();

        $jsonContent = $normalizer->normalize($event, 'json', ['groups' => 'events']);
   return new Response(json_encode($jsonContent));
    }






#[Route('/reserver/{idEvent}', name: 'app_event_reserver')]
public function reserver(int $idEvent, EntityManagerInterface $entityManager): JsonResponse
{
    $iduser = 28; // Exemple : l'ID de l'utilisateur est 28
    $user = $entityManager->getRepository(User::class)->find($iduser);
    $event = $entityManager->getRepository(Event::class)->find($idEvent);

    if (!$user) {
        return new JsonResponse(['success' => false, 'message' => 'L\'utilisateur n\'existe pas.']);
    }

    if (!$event) {
        return new JsonResponse(['success' => false, 'message' => 'L\'événement n\'existe pas.']);
    }

    if ($event->getDispoplaceEvent() == 0) {
        return new JsonResponse(['success' => false, 'message' => 'Désolé, il n\'y a plus de places disponibles.']);
    }

    $reserv = new Reserv();
    $reserv->setIdUser($user);
    $reserv->setIdEvent($event);
    $entityManager->persist($reserv);
    $entityManager->flush();

    $event->setDispoplaceEvent($event->getDispoplaceEvent() - 1);
    $entityManager->flush();

    return new JsonResponse(['success' => true, 'message' => 'Votre réservation a bien été enregistrée.']);
}



#[Route('/event/tri', name: 'app_event_tri')]
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

    // Transform the events into an associative array
    $eventsArray = array();
    foreach ($events as $event) {
        $eventArray = array(
            'id' => $event->getIdEvent(),
            'name' => $event->getNomEvent(),
            'date' => $event->getDateEvent()->format('Y-m-d H:i:s'),
            'location' => $event->getLocateEvent(),
          
        );
        $eventsArray[] = $eventArray;
    }

    // Return the events as JSON
    return new JsonResponse(array('events' => $eventsArray));
}































}