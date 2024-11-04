<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Form\FilterAdvertsType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/advert')]
final class AdvertController extends AbstractController
{
    #[Route(name: 'app_advert_index', methods: ['GET', 'POST'])]
    public function index(AdvertRepository $advertRepository, Request $req): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        }

        // pagination
        $page = $req->query->getInt('page', 1);
        $limit = 9;

        // formulaire filtres
        $form = $this->createForm(FilterAdvertsType::class);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $fields = $form->getData();
            foreach($fields as $field => $value) {
                ${$field} = $value;
            }
            
            switch($orderby){
                case 'newest':
                    $orderby = ['id' => 'desc'];
                    break;
                case 'oldest':
                    $orderby = null;
                    break;
                case 'popularity':
                    // $orderby = ['']
                    break;
            }
            
            $advert = $advertRepository->findBy(
                ['isOpen' => '1'],
            );

            $maxPage = ceil(count($advertRepository->findAll()) / $limit);
        }
        
        // no filter
        $adverts = $advertRepository->findby(
            ['isOpen' => '1'],
            ['id' => 'desc'],
            $limit,
            ($page - 1) * $limit
        );
        $maxPage = ceil(count($advertRepository->findAll()) / $limit);

        return $this->render('advert/index.html.twig', [
            'adverts' => $adverts,
            'current_page' => $page,
            'total_pages' => $maxPage,
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
                foreach($form->get($type)->getData() as $elem) {
                    // $tags[] = $elem;
                    $advert->addTag($elem);
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

    #[Route('/{id}', name: 'app_advert_show', methods: ['GET'])]
    public function show(Advert $advert, AdvertRepository $advertRepository): Response
    {
        if (!$this->isGranted('ROLE_USER') && !in_array($advert, $advertRepository->latest())) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
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
