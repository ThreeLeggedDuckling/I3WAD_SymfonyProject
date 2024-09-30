<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/adverts/detail/{id}', name: 'app_adverts_detail')]
    public function advertDisplay(Request $req, EntityManagerInterface $em): Response
    {
        $id = $req->get('id');
        $advert = $em->getRepository(Advert::class)->findOneBy(['id' => $id]);

        $comment = new Comment();

        $newComment = $this->createForm(CommentType::class, $comment);
        $newComment->handleRequest($req);

        if($newComment->isSubmitted() && $newComment->isValid()){
            $comment->setAdvert($advert);
            $comment->setAuthor($this->getUser());
            $comment->setPublishDate(new \DateTime());

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app_adverts_detail', ['id' => $id]);
        }

        $vars = [
            'advert' => $advert,
            'newComment' => $newComment,
        ];

        return $this->render('adverts/detail.html.twig', $vars);
    }
}
