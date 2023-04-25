<?php

namespace App\Controller;

use App\Entity\Station;
use App\Entity\ReservationVelo;
use App\Form\ReservationVeloType;
use App\Repository\StationRepository;
use App\Repository\ReservationVeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;



#[Route('/reservation/velo')]
class ReservationVeloController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'app_reservation')]
    public function mesres(): Response
    {   $r=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation = $r->findAll();
        return $this->render('reservation/reservation.html.twig', [
            'messi' => $messtation,
        ]);
    }

    #[Route('/b', name: 'app_reservationb')]
    public function reservationb(Request $request ,ReservationVeloRepository $reservationVeloRepository): Response
    {
        
        $search = $request->query->get('search');
        $category = $request->query->get('category');
        $price = $request->query->get('price');
        if ($search || $category || $price) {
            $messtation = $reservationVeloRepository->findBySearch($search, $category, $price);
            $r2=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation2 = $r2->findAll();
        } else {
            $r2=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation2 = $r2->findAll();
        $r=$this->getDoctrine()->getRepository(ReservationVelo::class);
        $messtation = $r->findAll();  }
        return $this->render('reservation/reservationb.html.twig', [
            'liss' => $messtation,
            'liss2' => $messtation2,
  
        ]);
    }

    #[Route('/{mohsen}/add', name: 'app_reservation_velo_new', methods: ['GEt', 'POST'])]
    public function new($mohsen, Request $request, ReservationVeloRepository $reservationVeloRepository, StationRepository $stationRepository): Response
    {
        $reservationVelo = new ReservationVelo();
        $station = $this->entityManager->getRepository(Station::class)->find($mohsen);
        $reservationVelo->setIdStation($station);    
        $nbr=$station->getVeloStation();
        $form = $this->createForm(ReservationVeloType::class, $reservationVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // $score = $recaptcha3Validator->getLastResponse()->getScore();
            $reservationVeloRepository->save($reservationVelo, true);
            $formData = $form->getData();
            $rnbr = $formData->getNbr();
            //$score = $recaptcha3Validator->getLastResponse()->getScore();
            if($rnbr > $nbr){
                $this->addFlash('error', 'nombre de velos non disponible: le max est '.$nbr);
            }
            else {
            $nnbr=$nbr-$rnbr;
            $station->setVeloStation($nnbr);
            $this->entityManager->persist($station);
            $this->entityManager->flush();

// Appel de la méthode sendsms depuis OffreRepository
            $reservationVeloRepository->sendsms();

            return $this->redirectToRoute('app_reservation', [], Response::HTTP_SEE_OTHER);
            }
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

    #[Route('/{idReservation}', name: 'app_reservation_velo_delete')]
    public function delecteC($idReservation, ReservationVeloRepository $rep, 
    ManagerRegistry $doctrine): Response
    {
        //récupérer la classe à supprimer
        $reservation=$rep->find($idReservation);
        $rnbr=$reservation->getNbr();
        $ids=$reservation->getIdStation()->getIdStation();
        $station = $this->entityManager->getRepository(Station::class)->find($ids); 
        $nbr=$station->getVeloStation();  
        $nnbr=$nbr+$rnbr;    
        $station->setVeloStation($nnbr);

        //Action de suppression
        //récupérer l'Entitye manager
        $em=$doctrine->getManager();
        $em->remove($reservation);
        //La maj au niveau de la bd
        $em->flush();
        return $this->redirectToRoute('app_reservation');
    }

 
}