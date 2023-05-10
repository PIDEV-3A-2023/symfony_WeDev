<?php

namespace App\Controller;

use Doctrine\DBAL\Exception\IntegrityConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationVeloRepository;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StationRepository;
use App\Form\StationType;
use App\Entity\Station;
use App\Entity\Velo;

/////////////////////////////////////json
#[Route('/houssem')]
class HoussemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/getall', name: 'getall')]
    public function stationb(NormalizerInterface $serializer): Response
    {
        $r=$this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $snorm=$serializer->normalize($messtation,'json',['groups'=>'stations']);
        $json= json_encode($snorm);
        return new Response($json);
    }
/////////////////////////////////////json

    #[Route('/add', name: 'add')]
    public function addstation(Request $request,NormalizerInterface $Normalizer): Response
    {
            $em = $this->getDoctrine()->getManager();
            $station = new station();   
            $station->setNomStation($request->get('nomStation'));
            $station->setLocalisationStation($request->get('localisationStation'));
            $station->setVeloStation($request->get('veloStation'));
            $em->persist($station);
            $em->flush();
            
            $jsonContent = $Normalizer->normalize($station, 'json', ['groups' => 'stations']);
        return new Response(json_encode($jsonContent));
    }
/////////////////////////////////////json
    #[Route('/del/{id}', name: 'del')]
    public function delStation($id, ManagerRegistry $doctrine, StationRepository $rep, ReservationVeloRepository $represervation): Response
    {          
        $r = $this->getDoctrine()->getRepository(Station::class);
        $messtation = $r->findAll();
        $station = $rep->find($id);
        $countreservation = count($represervation->findBy(['idStation' => $station->getIdStation()]));
        $wael = 'Impossible !!! (il existe des reservations dans cette station!)';
    
        if ($countreservation != 0) {
            return $this->render('reservation/stationb.html.twig', [
                'liss' => $messtation,
                'wael' => $wael,
                'siwael'=>''
            ]);
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($station);
        $entityManager->flush(); 
        return $this->redirectToRoute('app_stationb', [
            'liss' => $messtation,
            'wael' => '',
            'siwael'=>'Station supprimer avec succe!'
        ]);
    }
/////////////////////////////////////json
    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
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

    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
public function editj(Request $request, Station $station, EntityManagerInterface $entityManager, NormalizerInterface $serializer): JsonResponse
{
    $form = $this->createForm(StationType::class, $station);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $jsonContent = $serializer->normalize($station, 'json', ['groups' => 'stations']);
        return new JsonResponse($jsonContent, Response::HTTP_OK);
    }

    $jsonContent = $serializer->normalize($form->getErrors(true), 'json');
    return new JsonResponse($jsonContent, Response::HTTP_BAD_REQUEST);
}

#[Route('/del/{id}', name: 'del')]
public function delStationj($id, ManagerRegistry $doctrine, StationRepository $rep, ReservationVeloRepository $represervation, NormalizerInterface $serializer): JsonResponse
{
    $station = $rep->find($id);
    $countReservation = count($represervation->findBy(['idStation' => $station->getIdStation()]));

    if ($countReservation != 0) {
        $error = ['message' => 'Impossible !!! (il existe des reservations dans cette station!)'];
        $jsonContent = $serializer->normalize($error, 'json');
        return new JsonResponse($jsonContent, Response::HTTP_BAD_REQUEST);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($station);
    $entityManager->flush(); 

    $jsonContent = $serializer->normalize(['message' => 'Station supprimer avec succe!'], 'json');
    return new JsonResponse($jsonContent, Response::HTTP_OK);
}

}
