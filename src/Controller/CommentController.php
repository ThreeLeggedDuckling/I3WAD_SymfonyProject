<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/advert/{id}/comment/new', name: 'app_comment_add', methods: ['POST'])]
    public function addComment(Advert $advert, Request $request, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newComment = new Comment();

            $newComment->setContent($data['content']);
            if ($data['answering'] != null) {
                $newComment->setAnswerTo($commentRepository->find($data['answering']));
            }

            $newComment->setAdvert($advert);
            $newComment->setAuthor($this->getUser());

            $em->persist($newComment);
            $em->flush();

            return $this->redirectToRoute('app_advert_show', ['id' => $advert->getId()]);
        }

        // return au cas où problème de traitement
        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/comment/{id}/delete', name: 'app_comment_delete', methods: ['POST'])]
    public function deleteComment(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }
        elseif (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_advert_show', ['id' => $comment->getAdvert()->getId()]);
        }
        
        if($this->isCsrfTokenValid('delete'.$comment->getId(), $request->getPayload()->getString('_token'))) {
            // si le temps faire page admin où peut choisir motif supression
            $comment->setContent('deleted comment');
            $em->flush();
        }

        return $this->redirectToRoute('app_advert_show', ['id' => $comment->getAdvert()->getId()]);
    }


}
