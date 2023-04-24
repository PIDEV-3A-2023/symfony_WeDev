<?php

namespace App\Controller;

use App\Repository\VeloRepository;
use App\Entity\Velo;
use App\Form\VeloType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Station;
use Symfony\Component\Form\Extension\Core\Type\FileType;



#[Route('/velo')]
class VeloController extends AbstractController
{
    #[Route('/', name: 'app_velo_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $velos = $entityManager
            ->getRepository(Velo::class)
            ->findAll();

        return $this->render('velo/index.html.twig', [
            'velos' => $velos,
        ]);
    }

    #[Route('/new', name: 'app_velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // handle file upload
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle file exception
                }
                $velo->setImage($newFilename);
            }
    
            $entityManager->persist($velo);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('velo/new.html.twig', [
            'velo' => $velo,
            'form' => $form->createView(),
            'image_directory' => $this->getParameter('image_directory') // add the image directory to the view
        ]);
    }
    

    #[Route('/{idVelo}', name: 'app_velo_show', methods: ['GET'])]
    public function show(Velo $velo): Response
    {
        return $this->render('velo/show.html.twig', [
            'velo' => $velo,
        ]);
    }

    #[Route('/{idVelo}/edit', name: 'app_velo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Velo $velo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('velo/edit.html.twig', [
            'velo' => $velo,
            'form' => $form,
        ]);
    }

    #[Route('/{idVelo}', name: 'app_velo_delete', methods: ['POST'])]
    public function delete(Request $request, Velo $velo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$velo->getIdVelo(), $request->request->get('_token'))) {
            $entityManager->remove($velo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
    }
}
