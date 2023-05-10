<?php
namespace App\Controller;



use App\Entity\Velo;
use App\Form\VeloType;
use App\Entity\Station;
use App\Entity\Categorie;
use PhpOffice\PhpWord\PhpWord;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




#[Route('/velo')]
class VeloController extends AbstractController
{ 
    #[Route('/getall', name: 'getallv')]
    public function stationb(NormalizerInterface $serializer): Response
    {
        $r=$this->getDoctrine()->getRepository(Velo::class);
        $messtation = $r->findAll();
        $snorm=$serializer->normalize($messtation,'json',['groups'=>'velos']);
        $json= json_encode($snorm);
        return new Response($json);
    }

    #[Route('/velo', name: 'app_velo')]
    public function velo(UserRepository $userRepository): Response
    {$r=$this->getDoctrine()->getRepository(Velo::class);
        $mesvelos = $r->findAll();

        return $this->render('velo1/velo1.html.twig', [

            'v' => $mesvelos,
            'crepe' => $userRepository->find(53)
        ]);
    }

    #[Route('/{idVelo}/word',name:'app_velo_generate_word_file')]
    public function generateWordFile($idVelo):Response
    {
        $velo = $this->getDoctrine()->getRepository(Velo::class)->find($idVelo);
        $titre = $velo->getTitre();
        $prix = $velo->getPrix();
        $qte = $velo->getQte();
        

    // create the PhpWord object
    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    // Adding styles
    $phpWord->addTitleStyle(1, array('size' => 22, 'bold' => true), array('spaceAfter' => 240));
    $phpWord->addTitleStyle(2, array('size' => 18, 'bold' => true), array('spaceAfter' => 120));
    $phpWord->addParagraphStyle('myStyle', array('align' => 'center'));

    // Creating the new document...
    $section = $phpWord->addSection();

    // Adding a title
    $section->addTitle('Liste des Vélos', 1);

    // Adding bike details
    $section->addTitle('Détails du Vélo', 2);
    $section->addText("Numéro : " . $idVelo);
    $section->addText("Titre : " . $titre);
    $section->addText("Prix : " . $prix);
    $section->addText("Quantité : " . $qte);

    // Saving the document as OOXML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('detail_velo_' . $idVelo . '.docx');

    // Set up the response object
    $response = new Response();
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $response->headers->set('Content-Disposition', 'attachment; filename=detail_velo_' . $idVelo . '.docx');
    $response->setContent(file_get_contents('detail_velo_' . $idVelo . '.docx'));

    return $response;
   }
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
        $this->addFlash('success', 'Velo ajouté avec succès');

       /* // Replace these values with your Twilio account SID, auth token, and phone number
$twilio_sid = 'ACb011e177d137dbe84545e69a9e562b30';
$twilio_token = '9d7dbce112887f40e8f912e61c487847';
$twilio_phone_number = '+16206788499';

// Instantiate a new Twilio client with your account SID and auth token
$client = new \Twilio\Rest\Client($twilio_sid, $twilio_token);

// Use the client to send an SMS message to a specific phone number
$message = $client->messages->create(
    // The phone number to send the message to
    '+21629163358',
    array(
        // The Twilio phone number to send the message from
        'from' => $twilio_phone_number,
        // The body of the SMS message
        'body' => 'This is a test message from Twilio!'
    )
);

// Output the message SID to the console for debugging purposes
echo $message->sid;
*/

        return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('velo/new.html.twig', [
        'velo' => $velo,
        'form' => $form->createView(),
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
      // Ajouter la notification
    $this->addFlash('success', 'Velo supprimé avec succès');
    
        return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
    }
   
    
    
   

    // ...

   
}
