<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    // REPRENDRE ICI
    #[Route('/adverts/detail/{advert}', name: 'app_adverts_detail')]
    public function advertDisplay(Request $req): Response
    {
        $advert = $req->get('advert');

        return $this->render('adverts/detail.html.twig');
    }
}
