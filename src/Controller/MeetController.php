<?php

namespace App\Controller;

use App\Entity\Meet;
use App\Form\Meet\NewMeetFormType;
use App\Repository\MeetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MeetController extends AbstractController
{
    private MeetRepository $meetRepository;

    public function __construct(MeetRepository $meetRepository)
    {
        $this->meetRepository = $meetRepository;
    }

    #[Route('/meet', name: 'app_meet')]
    public function index(): Response
    {
        $meets = $this->meetRepository->findAll(); // Ceci renvoi tout les rdv de la base de donnée (Il faut afficher uniquement celle don't les dates sont d'actualité) donc à modifié

        return $this->render('meet/index.html.twig', [
            "meets" => $meets,
        ]);
    }

    #[Route('/meet/show/{id}', name: 'app_meet_show')]
    public function show(Meet $meet): Response
    {
        // $meet = L'entité envoyer lors que l'on consulte la page. Il est ratacher au {id}

        return $this->render('meet/showMeet.html.twig', [
            'meet' => $meet,
        ]);
    }

    #[Route('/meet/new', name: 'app_meet_new')]
    public function new(Request $request): Response
    {
        $meet = new Meet();

        

        return $this->renderForm('meet/newMeet.html.twig', [
        ]);
    }
}
