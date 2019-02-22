<?php

namespace App\Controller;

use App\Service\UserNotification;
use Nexmo\Client\Exception\Exception;
use Nexmo\Client\Exception\Request;
use Nexmo\Client\Exception\Server;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SendMessageController extends AbstractController
{
    /**
     * @Route("/send/message", name="send_message")
     *
     * @param UserNotification $userNotification
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserNotification $userNotification)
    {
        $errorMessage = null;

        try {
            $userNotification->notifyBySms(
                'Nexmo',
                'Nexmo is happy to send conference schedule ' .
                    $this->generateUrl('schedule', [], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        } catch (Server | Request | Exception $exception) {
            $errorMessage = $exception->getMessage();
        }

        return $this->render('send_message/index.html.twig', [
            'controller_name' => 'SendMessageController',
            'errorMessage' => $errorMessage
        ]);
    }
}
