<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    
    #[Route('/news', name: 'news', defaults: ['page' => '1', '_format' => 'html'], methods: ['GET'])]
    #[Route('/news/page/{page<[1-9]\d*>}', name: 'news_paginated', defaults: ['_format' => 'html'], methods: ['GET'])]
    #[Cache(smaxage: 10)]
    public function index(NewsRepository $news,int $page): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $allNews = $news->findLatest($page);

        return $this->render('news/index.html.twig', [
            'paginator' => $allNews,
        ]);
    }

    #[Route('/news/{id}/delete', name: 'news_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN", message: "not found", statusCode: 404)]
    public function delete(ManagerRegistry $doctrine, int $id) {
        $entityManager = $doctrine->getManager();
        $news = $doctrine->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('news');
    }


}
