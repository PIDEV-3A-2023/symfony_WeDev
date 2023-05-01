<?php

namespace App\Controller;

use App\Entity\TypeRec;
use App\Form\TypeRec1Type;
use App\Repository\TypeRecRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rim')]
class RimController extends AbstractController
{
    #[Route('/', name: 'app_rim_index', methods: ['GET'])]
    public function index(TypeRecRepository $typeRecRepository): Response
    {
        return $this->render('rim/index.html.twig', [
            'type_recs' => $typeRecRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rim_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeRecRepository $typeRecRepository): Response
    {
        $typeRec = new TypeRec();
        $form = $this->createForm(TypeRec1Type::class, $typeRec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRecRepository->save($typeRec, true);

            return $this->redirectToRoute('app_rim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim/new.html.twig', [
            'type_rec' => $typeRec,
            'form' => $form,
        ]);
    }

    #[Route('/{idType}', name: 'app_rim_show', methods: ['GET'])]
    public function show(TypeRec $typeRec): Response
    {
        return $this->render('rim/show.html.twig', [
            'type_rec' => $typeRec,
        ]);
    }

    #[Route('/{idType}/edit', name: 'app_rim_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeRec $typeRec, TypeRecRepository $typeRecRepository): Response
    {
        $form = $this->createForm(TypeRec1Type::class, $typeRec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRecRepository->save($typeRec, true);

            return $this->redirectToRoute('app_rim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rim/edit.html.twig', [
            'type_rec' => $typeRec,
            'form' => $form,
        ]);
    }

    #[Route('/{idType}', name: 'app_rim_delete', methods: ['POST'])]
    public function delete(Request $request, TypeRec $typeRec, TypeRecRepository $typeRecRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeRec->getIdType(), $request->request->get('_token'))) {
            $typeRecRepository->remove($typeRec, true);
        }

        return $this->redirectToRoute('app_rim_index', [], Response::HTTP_SEE_OTHER);
    }
}
