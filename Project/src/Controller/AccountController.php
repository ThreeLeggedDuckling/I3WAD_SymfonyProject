<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\NewMailType;
use App\Form\NewPasswordType;
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

    #[Route('/account/manage', name: 'app_manage_account')]
    public function manage(Request $req): Response
    {
        $emailForm = $this->createForm(NewMailType::class);
        $passwordForm = $this->createForm(NewPasswordType::class);

        $emailForm->handleRequest($req);
        if($emailForm->isSubmitted() && $emailForm->isValid()){
            echo 'email marche';
        }

        $passwordForm->handleRequest($req);
        if($passwordForm->isSubmitted() && $passwordForm->isValid()){
            echo 'mdp marche';
        }

        $vars = ['emailForm' => $emailForm, 'passwordForm' => $passwordForm];
        return $this->render('account/manage.html.twig', $vars);
    }

    #[Route('/account/manage/{id}/delete', name: 'app_delete_account')]
    public function deleteAccount(Request $req): Response
    {
        $id = $req->get('id');

        return $this->render('account/deleteConfirm.html.twig');
    }
}
