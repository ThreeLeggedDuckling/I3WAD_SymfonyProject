<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(AdvertRepository $advertRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'latest' => $advertRepository->latest(),
            'adverts' => $advertRepository->findAll(),
        ]);
    }
}