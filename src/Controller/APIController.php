<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/user/add', name: 'user_add', methods: ['POST'])]
    public function addUser(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setNomUser($request->request->get('nom'));
        $user->setPrenomUser($request->request->get('prenom'));
        $user->setDateNaiss(new \DateTime($request->request->get('date_naiss')));
        $user->setNumTel($request->request->get('num_tel'));
        $user->setEmail($request->request->get('email'));
        $user->setAdresse($request->request->get('adresse'));
        $user->setImgUser($request->request->get('img_user'));
        $user->setMdp($request->request->get('mdp'));
        $user->setRole($request->request->get('role'));
        $user->setEtatCompte($request->request->get('etat_compte'));
        $entityManager->persist($user);
        $entityManager->flush();
    
        $response = new JsonResponse(['status' => 'added'], Response::HTTP_CREATED);
        return $response;
    }

    
    #[Route('/user', name: 'user', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {        
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->findAll();

        $responseArray = array();
        foreach ($users as $user) {
            $responseArray[] = array(
                'id' => $user->getIduser(),
                'nom' => $user->getNomuser(),
                'prenom' => $user->getPrenomuser(),
                'date_naiss' => $user->getDatenaiss()->format('Y-m-d'),
                'num_tel' => $user->getNumtel(),
                'email' => $user->getEmail(),
                'adresse' => $user->getAdresse(),
                'img_user' => $user->getImguser(),
                'mdp' => $user->getMdp(),
                'role' => $user->getRole(),
                'etat_compte' => $user->getEtatcompte(),
            );
        }

        $responseData = json_encode($responseArray);
        $response = new Response($responseData);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUser(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $response = new JsonResponse(['status' => 'deleted'], Response::HTTP_OK);
        return $response;
    }

    #[Route('/user/{id}', name: 'user_edit', methods: ['PUT'])]
    public function editUser(Request $request, $id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['status' => 'Failed']);
        }

        $user->setNomUser($request->request->get('nom'));
        $user->setPrenomUser($request->request->get('prenom'));
        $user->setDateNaiss(new \DateTime($request->request->get('date_naiss')));
        $user->setNumTel($request->request->get('num_tel'));
        $user->setEmail($request->request->get('email'));
        $user->setAdresse($request->request->get('adresse'));
        $user->setImgUser($request->request->get('img_user'));
        $user->setMdp($request->request->get('mdp'));
        $user->setRole($request->request->get('role'));
        $user->setEtatCompte($request->request->get('etat_compte'));

        $entityManager->persist($user);
        $entityManager->flush();

        $response = new JsonResponse(['status' => 'edited'], Response::HTTP_OK);
        return $response;
    }

    
}
