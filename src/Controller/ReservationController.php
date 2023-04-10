<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ReservationVelo;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReservationVeloRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ReservationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request): Response
    {
        $reservation = new ReservationVelo();     
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $reservation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_reservation');}
        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/addStudent', name: 'app_addS')]
    public function addStudent(ManagerRegistry $doctrine,
    Request $request)
{
    $reservation= new ReservationVelo();
$form=$this->createForm(ReservationType::class,$reservation);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                    //Action d'ajout
                       $em =$doctrine->getManager() ;
                       $em->persist($reservation);
                       $em->flush();
            return $this->redirectToRoute("app_reservation");
        }
    return $this->renderForm("reservation/reservation.html.twig",
                       array("form"=>$form));
                   }
}
