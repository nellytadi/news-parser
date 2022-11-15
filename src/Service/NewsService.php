<?php


namespace App\Service;


use App\Entity\News;
use App\Entity\Source;
use App\Repository\NewsRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

class NewsService
{

    /**
     * @var \App\Repository\NewsRepository
     */
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository) {
        $this->newsRepository = $newsRepository;
    }

    public function parser(Source $source): bool {

        $client = Client::createChromeClient();

        $client->request('GET', $source->getUrl());

        $crawler = $client->waitFor($source->getMainWrapper());


        $crawler->filter($source->getWrapper())->each(function (Crawler $crawl) use ($source) {

            if ($crawl->filter($source->getTitleSelector())->count() > 0) {
                $title = $crawl->filter($source->getTitleSelector())->text();
                $description = $crawl->filter($source->getDescriptionSelector())->last()->text();
                $image = $crawl->filter($source->getImageSelector())->attr('data-lazy-src');
                $url = $crawl->filter($source->getUrlSelector())->last()->attr('href');
                $date = $crawl->filter($source->getDateSelector())->first()->text();

                $checkIfNewsExists = $this->newsRepository->findOneBy(['title' => $title]);
                if (!is_null($checkIfNewsExists)) {
                    //update if record already exists
                    $checkIfNewsExists->setDate($date);
                    $checkIfNewsExists->setUpdatedAt(new DateTimeImmutable());
                    $this->newsRepository->save($checkIfNewsExists, true);
                } else {
                    $news = new News();
                    $news->setTitle($title);
                    $news->setDescription($description);
                    $news->setImage($image);
                    $news->setUrl($url);
                    $news->setDate($date);
                    $news->setSource($source);
                    $news->setUpdatedAt(new DateTimeImmutable());
                    $news->setCreatedAt(new DateTimeImmutable());
                    $this->newsRepository->save($news, true);
                }

            }
        });

        return true;
    }
}