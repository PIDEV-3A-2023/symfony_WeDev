<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\Velo1Type;
use App\Repository\VeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sahar')]
class SaharController extends AbstractController
{
    #[Route('/', name: 'app_sahar_index', methods: ['GET'])]
    public function index(VeloRepository $veloRepository): Response
    {
        return $this->render('sahar/index.html.twig', [
            'velos' => $veloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sahar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VeloRepository $veloRepository): Response
    {
        $velo = new Velo();
        $form = $this->createForm(Velo1Type::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veloRepository->save($velo, true);

            return $this->redirectToRoute('app_sahar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sahar/new.html.twig', [
            'velo' => $velo,
            'form' => $form,
        ]);
    }

    #[Route('/{idVelo}', name: 'app_sahar_show', methods: ['GET'])]
    public function show(Velo $velo): Response
    {
        return $this->render('sahar/show.html.twig', [
            'velo' => $velo,
        ]);
    }

    #[Route('/{idVelo}/edit', name: 'app_sahar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Velo $velo, VeloRepository $veloRepository): Response
    {
        $form = $this->createForm(Velo1Type::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veloRepository->save($velo, true);

            return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sahar/edit.html.twig', [
            'velo' => $velo,
            'form' => $form,
        ]);
    }

    #[Route('/{idVelo}', name: 'app_sahar_delete', methods: ['POST'])]
    public function delete(Request $request, Velo $velo, VeloRepository $veloRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$velo->getIdVelo(), $request->request->get('_token'))) {
            $veloRepository->remove($velo, true);
        }

        return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
    }
}
