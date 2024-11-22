<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MessageRepository $messageRepository, UserRepository $userRepository): Response
    {
        // $users = $userRepository->findAll();
        // $sample = $users[rand(0, count($users)-1)];

        $sample = $userRepository->find(27);
        $groups = $sample->getGroups();
        $discussions = [];
        foreach ($sample->getMessages() as $m) {
            if (!$m->isToGroup()) {
                if ($m->getAuthor() != $sample && !array_search($m->getAuthor(), $discussions)) {
                    $discussions[] = $m->getAuthor();
                }
                if ($m->getTarget() != $sample && !array_search($m->getTarget(), $discussions)) {
                    $discussions[] = $m->getTarget();
                }
            }
        }

        return $this->render('test/index.html.twig', [
            // 'users' => $users,
            'sample' => $sample,
            'groups' => $groups,
            'discussion' => $discussions,
        ]);
    }
}
