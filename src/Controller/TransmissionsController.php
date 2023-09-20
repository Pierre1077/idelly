<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransmissionsController extends AbstractController
{
    #[Route('/transmissions', name: 'app_transmissions')]
    public function index(): Response
    {
        return $this->render('transmissions/index.html.twig', [
            'controller_name' => 'TransmissionsController',
        ]);
    }
}
