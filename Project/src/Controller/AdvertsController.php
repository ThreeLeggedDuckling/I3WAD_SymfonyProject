<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdvertsController extends AbstractController
{
    #[Route('/adverts', name: 'app_adverts')]
    public function index(AdvertRepository $rep): Response
    {
        $lastAdverts = $rep->latest();
        $vars = ['latest' => $lastAdverts, 'requestTime' => new \DateTime()];

        return $this->render('adverts/index.html.twig', $vars);
    }
}
