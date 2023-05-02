<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;

 

class QrCodeController extends AbstractController
{


   #[Route('/qr-code/{idEvent}', name: 'app_event_qr_code', methods: ['GET'])]
    public function index(int $idEvent, ManagerRegistry $managerRegistry): Response
    {
        $event = $managerRegistry->getRepository(Event::class)->find($idEvent);

        if (!$event) {
            throw $this->createNotFoundException('L\'événement n\'existe pas.');
        }

        $qrCodeContent = sprintf(
            'Nom de l\'événement : %s, Date : %s, Lieu : %s',
            $event->getNomEvent(),
            $event->getDateEvent()->format('d/m/Y'),
            $event->getLocateEvent()
        );

        $qrCode = new QrCode($qrCodeContent);
        $qrCode->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(120)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
      
        $label = Label::create('')->setFont(new NotoSans(8));

        $writer = new PngWriter();

$qrCodeDataUri = $writer->write($qrCode, null, $label->setText($event->getNomEvent())->setFont(new NotoSans(20)))->getDataUri();

       return $this->render('qr_code/index.html.twig', [
    'qrCodeDataUri' => $qrCodeDataUri,
    'event' => $event,
]);
    }
}