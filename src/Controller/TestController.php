<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();
        $users = [];
        $groups = [];

        foreach ($messages as $m) {
            if (!array_search($m->getAuthor(), $users)) {
                $users[] = $m->getAuthor();
            }
            if ($m->getTarget() instanceof Group && !array_search($m->getTarget(), $groups)) {
                $groups[] = $m->getTarget();
            }
        }

        // dd(count($messages), count($users), $users, count($groups), $groups);

        return $this->render('test/index.html.twig', [
            'messages' => $messages,
            'users' => $users,
            'groups' => $groups
        ]);
    }
}
