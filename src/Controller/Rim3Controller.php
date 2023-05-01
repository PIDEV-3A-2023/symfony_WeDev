<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation2Type;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rim3')]
class Rim3Controller extends AbstractController
{
    #[Route('/', name: 'app_rim3_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('rim3/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rim3_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_rim3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim3/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_rim3_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('rim3/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idRec}/edit', name: 'app_rim3_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_rim3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim3/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_rim3_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_rim3_index', [], Response::HTTP_SEE_OTHER);
    }
}
