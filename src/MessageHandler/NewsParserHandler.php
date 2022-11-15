<?php


namespace App\MessageHandler;

use App\Repository\NewsRepository;
use App\Service\NewsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Message\NewsParser;

#[AsMessageHandler]
class NewsParserHandler
{

    /**
     * @var \App\Repository\NewsRepository
     */
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {

        $this->newsRepository = $newsRepository;
    }

    public function __invoke(NewsParser $parser)
    {
        $newsService = new NewsService($this->newsRepository);
        $newsService->parser($parser->getContent());
    }

}