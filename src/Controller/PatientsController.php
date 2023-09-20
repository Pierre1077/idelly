<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientsType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientsController extends AbstractController
{
    #[Route('/patients', name: 'app_patients')]
    public function index(
        Request $request,
        PatientRepository $patientRepository,
        EntityManagerInterface $entityManager,

    ): Response
    {

//        $patient = new Patient();
//        $form = $this->createForm(PatientsType::class, $patient);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
//            $entityManager->persist($patient); // on effectue les mise à jours internes
//            $entityManager->flush(); // on effectue la mise à jour vers la base de données
//            return $this->redirectToRoute('app_patients'); // on redirige vers la route show_task avec l'id du post créé ou modifié
//        }
        $patients = $patientRepository->findAll();
        return $this->render('patients/index.html.twig', [
            'controller_name' => 'PatientsController',
            'patients' => $patients,

        ]);
    }

    #[Route('/patients/add', name: 'app_patients_add')]
    public function add(
        Request $request,
        PatientRepository $patientRepository,
        EntityManagerInterface $entityManager,

    ): Response
    {

        $patient = new Patient();
        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ // test si le formulaire a été soumis et s'il est valide
            $entityManager->persist($patient); // on effectue les mise à jours internes
            $entityManager->flush(); // on effectue la mise à jour vers la base de données
            return $this->redirectToRoute('app_patients'); // on redirige vers la route show_task avec l'id du post créé ou modifié
        }
        return $this->render('patients/add/add.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/patients/view/{id}', name: 'app_patients_view')]
    public function view(
        Request $request,
        PatientRepository $patientRepository,
        EntityManagerInterface $entityManager,

    ): Response
    {


        return $this->render('patients/view/view.html.twig', [

        ]);
    }

}
