<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientsController extends AbstractController
{
    #[Route('/patients', name: 'app_patients')]
    public function index(): Response
    {
        return $this->render('patients/index.html.twig', [
            'controller_name' => 'PatientsController',
        ]);
    }
}
