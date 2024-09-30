<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/account/manage/{id}', name: 'app_manage_account')]
    public function manage(Request $req, EntityManagerInterface $em): Response
    {
        $id = $req->get('id');
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(AccountType::class, $user);

        $vars = ['user' => $user, 'userdata' => $form];
        return $this->render('account/manage.html.twig', $vars);
    }
}
