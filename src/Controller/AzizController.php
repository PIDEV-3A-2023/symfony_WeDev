<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User2Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/aziz')]
class AzizController extends AbstractController
{
    #[Route('/', name: 'app_aziz_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('aziz/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aziz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_aziz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aziz/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{iduser}', name: 'app_aziz_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('aziz/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{iduser}/edit', name: 'app_aziz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_aziz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aziz/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{iduser}', name: 'app_aziz_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_aziz_index', [], Response::HTTP_SEE_OTHER);
    }
}
