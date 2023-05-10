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

#[Route('/rim2')]
class Rim2Controller extends AbstractController
{
    #[Route('/', name: 'app_rim2_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository,UserRepository $userRepository): Response
    {
        return $this->render('rim2/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
            'crepe' => $userRepository->find(53)
        ]);
    }

    #[Route('/new', name: 'app_rim2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_rim2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim2/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_rim2_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('rim2/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idRec}/edit', name: 'app_rim2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_rim2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim2/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_rim2_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_rim2_index', [], Response::HTTP_SEE_OTHER);
    }
}
