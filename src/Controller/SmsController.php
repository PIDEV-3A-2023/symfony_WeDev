<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twilio\Rest\Client;

class SmsController extends AbstractController
{
    public function sendSms()
    {
        $sid = 'AC794c0dce961b6a19bcbcfed0673aa08f';
        $token = 'f969fb9e92087c4b9811af3de1a254b9';
        $client = new Client($sid, $token);

        $message = $client->messages->create(
            "+21692841145",
            [
                'from' => "+16813233355",
                'body' => 'Votre compte a etait cree avec succes  '
            ]
        );
    }
}
