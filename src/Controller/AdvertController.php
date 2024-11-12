<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Comment;
use App\Form\AdvertType;
use App\Form\CommentType;
use App\Form\FilterAdvertsType;
use App\Repository\AdvertRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/advert')]
final class AdvertController extends AbstractController
{
    #[Route(name: 'app_advert_index', methods: ['GET', 'POST'])]
    public function index(AdvertRepository $advertRepository, Request $request, PaginatorInterface $paginator): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $page = $request->query->getInt('page', 1); // ?page
        $limit = 9;

        // dd($request->query);

        $form = $this->createForm(FilterAdvertsType::class, null, ['allow_extra_fields' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $page = 1;
            $filters = $form->getData();
            $cleanData = [];
            foreach ($filters as $k => $v) {
                if (!empty($filters[$k])) {
                    $cleanData[$k] = $v;
                }
            }

            // parametres GET
            $params['page'] = $page;
            foreach ($cleanData as $k => $v) {
                if ($v instanceof \DateTime) {
                    $params[$k] = date_format($v,"Y-m-d");
                } else {
                    $params[$k] = $v->getId();
                }
            }
            // dd($cleanData, $params);

            return $this->redirectToRoute('app_advert_index', $params);
        }

        // population form selon GET
        $filters = $request->query->all();
        $form->submit($filters);
        $filters = $form->getData();

        $qb = $advertRepository->filterSearch($filters);
        $adverts = $paginator->paginate(
            $qb,
            $page,
            $limit,
            array('wrap-queries' => true) // solution 'Cannot count query that uses a HAVING clause. Use the output walkers for pagination'
        );

        return $this->render('advert/index.html.twig', [
            'adverts' => $adverts,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_advert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $advert->setAuthor($this->getUser());
            $advert->setPublishDate(new \DateTime());
            $advert->setOpen(true);

            $tagtypes = ['game', 'genre', 'level', 'modality'];
            foreach($tagtypes as $type) {
                $tag = $form->get($type)->getData();
                if (isset($tag)) {
                    $advert->addTag($tag);
                }
            }

            $entityManager->persist($advert);
            $entityManager->flush();

            // réparer problème timeAgo dans vue
            return $this->redirectToRoute('app_advert_show', ['id' => $advert->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advert/new.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_advert_show', methods: ['GET', 'POST'])]
    public function show(Advert $advert, AdvertRepository $advertRepository, Request $request, CommentRepository $commentRepository, EntityManagerInterface $em): Response
    {
        if (!$this->isGranted('ROLE_USER') && !in_array($advert, $advertRepository->latest())) {
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
            $newComment->setPublishDate(new \DateTime());
            $newComment->setAuthor($this->getUser());

            // dd($newComment);
            $em->persist($newComment);
            $em->flush();

            return $this->redirectToRoute('app_advert_show', ['id' => $advert->getId()]);
        }

        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_advert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Advert $advert, EntityManagerInterface $entityManager): Response
    {
        // vérification droit modification
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }
        elseif ($this->getUser() != $advert->getAuthor()) {
            return $this->redirectToRoute('app_advert_show', ['id' => $advert->getId()]);
        }

        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_advert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    // vérifier comment implémenter suppression
    // #[Route('/{id}', name: 'app_advert_delete', methods: ['POST'])]
    // public function delete(Request $request, Advert $advert, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->getUser() != $advert->getAuthor() || $this->isGranted('ROLE_ADMIN')) {
    //         return $this->redirectToRoute('app_advert_show', ['id' => $advert->getId()]);
    //     }

    //     if ($this->isCsrfTokenValid('delete'.$advert->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($advert);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_advert_index', [], Response::HTTP_SEE_OTHER);
    // }
}
