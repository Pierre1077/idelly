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
use Symfony\Component\HttpFoundation\JsonResponse;


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

    public function search(Request $request, PatientRepository $patientRepository)
    {
        $query = $request->query->get('query'); // Récupérer la chaîne de recherche depuis la requête AJAX

        // Effectuer la recherche dans la base de données en utilisant le PatientRepository
        $patients = $patientRepository->searchPatients($query); // Vous devrez implémenter cette méthode dans votre PatientRepository

        // Reformater les données pour inclure "name" et "firstname" dans le JSON
        $formattedPatients = [];
        foreach ($patients as $patient) {
            $formattedPatients[] = [
                'id' => $patient->getId(), // Remplacez par la méthode qui récupère le nom
                'name' => $patient->getName(), // Remplacez par la méthode qui récupère le nom
                'firstname' => $patient->getFirstname(), // Remplacez par la méthode qui récupère le prénom
            ];
        }

        // Renvoyer les résultats au format JSON avec les propriétés "name" et "firstname"
        return new JsonResponse(['patients' => $formattedPatients]);
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
        $id,
        PatientRepository $patientRepository
    ): Response {
        // Récupérer le patient en fonction de l'ID
        $patient = $patientRepository->find($id);

        // Vérifiez si le patient existe
        if (!$patient) {
            throw $this->createNotFoundException('Patient non trouvé');
        }

        return $this->render('patients/view/view.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/patients/delete/{id}', name: 'app_patients_delete')]
    public function delete(
        $id,
        PatientRepository $patientRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer le patient en fonction de l'ID
        $patient = $patientRepository->find($id);

        // Vérifiez si le patient existe
        if (!$patient) {
            throw $this->createNotFoundException('Patient non trouvé');
        }

        // Supprimer le patient
        $entityManager->remove($patient);
        $entityManager->flush();

        return $this->redirectToRoute('app_patients');
    }







}
