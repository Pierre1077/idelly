<?php

namespace App\Controller;

use App\Entity\Meet;
use App\Entity\Passage;
use App\Form\Meet\NewMeetFormType;
use App\Repository\MeetRepository;
use DateTime;
use Doctrine\DBAL\Types\DateType;
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

    #[Route('/meet/{day}', name: 'app_meet')]
    public function index(string $day): Response
    {
        // La date d'aujourd'hui
        $dayDateTime = DateTime::createFromFormat('d-m-Y', $day);

        $meets = $this->meetRepository->findBy(['user' => $this->getUser()]); // Ceci renvoi tout les rdv de la base de donnée (Il faut afficher uniquement celle don't les dates sont d'actualité) donc à modifié
        return $this->render('meet/index.html.twig', [
            "meets" => $meets,
            "dayDateTime" => $dayDateTime,
        ]);
    }

    #[Route('/meet/{day}/{passage}/valided', name: 'app_passage_validated')]
    public function validatedPassage(string $day, Passage $passage): Response
    {
        $passage->setEtatPassage(true);
        $this->entityManager->persist($passage);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_meet', ['day' => $day]);
    }

    #[Route('/meet/{day}/{passage}/denied', name: 'app_passage_denied')]
    public function deniedPassage(string $day, Passage $passage): Response
    {
        $passage->setEtatPassage(false);
        $this->entityManager->persist($passage);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_meet', ['day' => $day]);
    }

    #[Route('/meet/show/{id}', name: 'app_meet_show')]
    public function show(Meet $meet): Response
    {
        // $meet = L'entité envoyer lors que l'on consulte la page. Il est ratacher au {id}

        return $this->render('meet/showMeet.html.twig', [
            'meet' => $meet,
        ]);
    }

    #[Route('/new/meet', name: 'app_meet_new')]
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
            switch ($meet->getTypePassage()) {
                case 'Tous les jours':
                    $i = 1;
                    break;
                case 'Tous les 3 jours':
                    $i = 3;
                    break;
            }

            if ($i != 0 and $meet->getDateDebut() != null) {
                $date = $meet->getDateDebut();
                while ($date <= $meet->getDateFin()) {
                    $passage = new Passage();
                    $passage->setMeet($meet);
                    $passage->setDatePassage($date);

                    $hour = $form->get("hour")->getData();
                    $passage->setHour($hour);

                    $this->entityManager->persist($passage);
                    $this->entityManager->flush();

                    date_modify($date, '+' . $i . ' day');
                }
            }

            $currentDate = (new \DateTime())->format('d-m-Y');
            return $this->redirectToRoute('app_meet', ['day' => $currentDate]);
        }

        return $this->render('meet/newMeet.html.twig', [
            'form' => $form,
        ]);
    }
}
