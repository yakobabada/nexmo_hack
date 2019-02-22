<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route("/schedule", name="schedule")
     */
    public function index()
    {
        $data = json_decode(file_get_contents('http://api.joind.in/v2.1/events/7001/talks?resultsperpage=50'), true);

        return $this->render('schedule/index.html.twig', [
            'talks' => $data['talks'],

        ]);
    }
}
