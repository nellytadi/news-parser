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

        $crawler = $client->waitFor('.sidebar-center');


        $crawler->filter('.lenta-item')->each(function (Crawler $crawl) use ($source) {

            if ($crawl->filter('h2')->count() > 0) {
                $title = $crawl->filter('h2')->text();
                $description = $crawl->filter('p')->last()->text();
                $image = $crawl->filter('img')->attr('data-lazy-src');
                $url = $crawl->filter('a')->last()->attr('href');
                $date = $crawl->filter('.meta-datetime')->first()->text();

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