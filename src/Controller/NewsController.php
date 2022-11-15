<?php

namespace App\Controller;

use App\Entity\News;
use App\Message\NewsParser;
use App\Repository\NewsRepository;
use App\Repository\SourceRepository;
use App\Service\NewsService;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
//    /**
//     * @var \App\Repository\SourceRepository
//     */
//    private SourceRepository $sourceRepository;
//    /**
//     * @var \App\Repository\NewsRepository
//     */
//    private NewsRepository $newsRepository;
//
//    public function __construct(SourceRepository $sourceRepository, NewsRepository $newsRepository) {
//        $this->sourceRepository = $sourceRepository;
//        $this->newsRepository =$newsRepository;
//    }
//
//    #[Route('/test', name: 'test', methods: ['GET'])]
//    public function test(){
//        $sources = $this->sourceRepository->findAll();
//
//        foreach ($sources as $source) {
//            $newsService = new NewsService($this->newsRepository);
//            $newsService->parser($source);
//        }
//    }
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
