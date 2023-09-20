<?php

namespace App\Controller;

use App\Entity\Meet;
use App\Entity\Passage;
use App\Form\Meet\NewMeetFormType;
use App\Repository\MeetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MeetController extends AbstractController
{
    private MeetRepository $meetRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MeetRepository $meetRepository, EntityManagerInterface $entityManager)
    {
        $this->meetRepository = $meetRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/meet', name: 'app_meet')]
    public function index(): Response
    {
        // La date d'aujourd'hui 
        $today = new \DateTime('now');
        $meets = $this->meetRepository->findBy(['user' => $this->getUser()]); // Ceci renvoi tout les rdv de la base de donnée (Il faut afficher uniquement celle don't les dates sont d'actualité) donc à modifié

        return $this->render('meet/index.html.twig', [
            "meets" => $meets,
            "today" => $today
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

        $form = $this->createForm(NewMeetFormType::class, $meet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meet->setUser($this->getUser());

            $this->entityManager->persist($meet);
            $this->entityManager->flush();

            $i = 0;
            switch ($meet->getTypePassage()){
                case 'Tous les jours' :
                    $i = 1;
                    break;
                case 'Tous les 3 jours' :
                    $i = 3;
                    break;
            }

            if ($i != 0 and $meet->getDateDebut() != null){
                $date = $meet->getDateDebut();
                while ($date <= $meet->getDateFin()){
                    $passage = new Passage();
                    $passage->setMeet($meet);
                    $passage->setDatePassage($date);

                    $hour = $form->get("hour")->getData();
                    $passage->setHour($hour);

                    $this->entityManager->persist($passage);
                    $this->entityManager->flush();

                    date_modify($date,'+'.$i.' day');
                }
            }



            return $this->redirectToRoute('app_meet');
        }

        return $this->render('meet/newMeet.html.twig', [
            'form'=>$form,
        ]);
    }

}
