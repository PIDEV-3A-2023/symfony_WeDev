<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation1Type;
use App\Repository\UserRepository;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/reclamation_front')]
class ReclamationFrontController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_front_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository,UserRepository $userRepository): Response
    {
        return $this->render('reclamation_front/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
            'crepe' => $userRepository->find(37)
        ]);
    }

    #[Route('/new', name: 'app_reclamation_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation_front/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_reclamation_front_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation_front/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idRec}/edit', name: 'app_reclamation_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);
            
            return $this->redirectToRoute('app_reclamation_front_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('reclamation_front/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    
    #[Route('/{idRec}', name: 'app_reclamation_front_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }
        
        return $this->redirectToRoute('app_reclamation_front_index', [], Response::HTTP_SEE_OTHER);
    }
    
    


    

}
