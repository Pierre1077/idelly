<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoreController extends AbstractController
{
    #[Route('/more', name: 'app_more')]
    public function index(): Response
    {
        return $this->render('more/index.html.twig', [
            'controller_name' => 'MoreController',
        ]);
    }
}
