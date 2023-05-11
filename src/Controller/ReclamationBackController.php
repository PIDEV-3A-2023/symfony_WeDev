<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\Reclamation2Type;
use App\Repository\ReclamationRepository;
use App\Repository\TypeRecRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[Route('/reclamation_back')]
class ReclamationBackController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_back_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation_back/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reclamation_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation_back/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_reclamation_back_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idRec}/edit', name: 'app_reclamation_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation2Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation_back/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idRec}', name: 'app_reclamation_back_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_back_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/api/getall', name: 'reclamation_api', methods: ['GET', 'POST'])]
    function getAllAPI(ReclamationRepository $reclamationRepository)
    {
        $reclamations = $reclamationRepository->findAll();
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);
        // $formatted = $serializer->normalize($reclamations,'json', [AbstractNormalizer::ATTRIBUTES => ['idRec','dateRec','descriptionRec','image','typeRec','typeRec','etat','idU'=>['id']]]);
        // Get reclamations with specific format
        $formatted = $serializer->normalize($reclamations, 'json', [
            AbstractNormalizer::CALLBACKS => [
                'typeRec' => function ($typeRec) {
                    return $typeRec->getEtatRec();
                }
            ],
            AbstractNormalizer::ATTRIBUTES => [
                'idRec',
                'dateRec',
                'descriptionRec',
                'image',
                'typeRec'
            ]
        ]);
        // $formatted = $serializer->normalize($reclamations);

        return new JsonResponse($formatted);
    }

    #[Route('/api/delete/{id}', name: 'reclamation_api_delete', methods: ['DELETE'])]
    public function deleteAPI(Request $request, ReclamationRepository $reclamationRepository, Reclamation $reclamation)
    {
        $reclamation = $reclamationRepository->find($request->get('id'));
        $reclamationRepository->remove($reclamation, true);
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());

        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);
        $formatted = $serializer->normalize($reclamation);

        return new JsonResponse($formatted);
    }
    
    #[Route('/api/create', name: 'reclamation_api_create2', methods: ['POST'])]
    public function addUser(Request $request, UserRepository $userRepository, TypeRecRepository $typeRecRepository): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        $reclamation->setImage($request->get('etat'));
        // $reclamation->setEtat($request->get('sujet'));
        $reclamation->setDescriptionRec($request->get('description'));
        // $reclamation->setEtat("Pending");
        $reclamation->setDateRec(new \DateTime());
        
        $user = $userRepository->find(37);
        $typeRec = $typeRecRepository->find(2);
        $reclamation->setUser($user);
        $reclamation->setTypeRec($typeRec);


        $entityManager->persist($reclamation);
        $entityManager->flush();

        $response = new JsonResponse(['status' => 'added'], Response::HTTP_CREATED);
        return $response;
    }
}