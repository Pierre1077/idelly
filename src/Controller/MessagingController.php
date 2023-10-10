<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\GroupChat;
use App\Entity\Messaging;
use App\Repository\GroupChatRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NewMessageFormType;

class MessagingController extends AbstractController
{
    private UserRepository $userRepository;
    private GroupChatRepository $groupChatRepository;
    private EntityManagerInterface $entityManager;


    public function __construct(UserRepository $userRepository, GroupChatRepository $groupChatRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->groupChatRepository = $groupChatRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/messaging', name: 'messaging')]
    public function index(): Response
    {
        $user = $this->getUser();
        $groupChats = $user->getGroupChats();
        $users = $this->userRepository->findAll();

        return $this->render('messaging/index.html.twig', [
            'user' => $user,
            'groupChats' => $groupChats,
            'users' => $users,
        ]);
    }

    #[Route('/messaging/{id}', name: 'redirection_group')]
    public function redirectionGroup(User $userDistant): Response
    {
        $user = $this->getUser();
        $groupChats = $user->getGroupChats();

        $groupChatCommun = null;
        foreach ($groupChats as $groupChat) {
            if ($groupChat->getUsers()->contains($userDistant)) {
                $groupChatCommun = $groupChat;
            }
        }

        // Si le groupe n'existe pas, on le crée
        if ($groupChatCommun == null) {
            $group = new GroupChat();
            $group->addUser($user);
            $group->addUser($userDistant);
            $this->entityManager->persist($group);
            $this->entityManager->flush();

            return $this->redirectToRoute('messaging_groupChat', ['id' => $group->getId()]);
        }

        // Si le groupe existe, on le renvoi
        return $this->redirectToRoute('messaging_groupChat', ['id' => $groupChatCommun->getId()]);
    }

    #[Route('/messaging/groupChat/{id}', name: 'messaging_groupChat')]
    public function groupChat(Request $request, GroupChat $groupChat): Response
    {
        $user = $this->getUser();
        $userDistant = null;

        foreach ($groupChat->getUsers() as $userGroup) {
            if ($userGroup != $user) {
                $userDistant = $userGroup;
            }
        }

        $messages = $groupChat->getMessages();

        $message = new Messaging();
        $form = $this->createForm(NewMessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuteur($user);
            $message->setGroupChat($groupChat);
            $message->setDateContent(new \DateTime());
            $groupChat->setLastUpdate(new \DateTime());

            $this->entityManager->persist($message);
            $this->entityManager->persist($groupChat);
            $this->entityManager->flush();

            return $this->redirectToRoute('messaging_groupChat', ['id' => $groupChat->getId()]);
        }

        return $this->render('messaging/groupChat.html.twig', [
            'user' => $user,
            'userDistant' => $userDistant,
            'messages' => $messages,
            'form' => $form,
        ]);
    }
}
