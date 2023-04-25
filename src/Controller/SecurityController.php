<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateType;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    #[Route('/', name: 'security_index')]
    public function index()
    {
        $data = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('security/index.html.twig', [
            'list' => $data,
        ]);
    }

    #[Route('/inscription', name: 'security_registration')]
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $User = new User();
        $response = new Response();
        $form = $this->createForm(RegistrationType::class, $User);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('image')->getData();

            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('User_Image_directory'),
                    $newFilename
                );
                $User->setImage($newFilename);
            }

            $response = $this->forward('App\Controller\SmsController::sendSms');
            $hash = $encoder->encodePassword($User, $User->getPassword());
            $User->setPassword($hash);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($User);
            $manager->flush();
            $this->addFlash('notice', 'Submitted successfuly!!');
            //return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(), 'sms_response' => $response->getContent(),
        ]);
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'sms_response' => false
        ]);
    }
    #[Route('/connexion', name: 'security_login')]
    public function login(Request $request)
    {
        return $this->render('security/login.html.twig');
    }
    #[Route('/deconnexion', name: 'security_logout')]
    public function logout()
    {
        return $this->redirectToRoute('app_login');
    }
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, $id, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UpdateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('image')->getData();

            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('User_Image_directory'),
                    $newFilename
                );
                $user->setImage($newFilename);
            }
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice', 'update successfuly!!');
            return $this->redirectToRoute('security_index');
        }
        return $this->render('security/updateUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id): Response
    {
        $data = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();
        $this->addFlash('notice', 'Deleted successfuly!!');
        return $this->redirectToRoute('security_index');
    }
}
