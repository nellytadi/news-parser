<?php

namespace App\Command;

use App\Message\NewsParser;
use App\Repository\NewsRepository;
use App\Repository\SourceRepository;
use App\Service\NewsService;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'news:parser',
    description: 'Crawl websites and store articles',
)]
class NewsParserCommand extends Command
{
    /**
     * @var \App\Repository\SourceRepository
     */
    private SourceRepository $sourceRepository;

    /**
     * @var \Symfony\Component\Messenger\MessageBusInterface
     */
    private MessageBusInterface $messageBus;


    public function __construct(SourceRepository $sourceRepository, MessageBusInterface $messageBus) {
        parent::__construct();
        $this->sourceRepository = $sourceRepository;
        $this->messageBus = $messageBus;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $io->info('Parsing is starting...');

        $sources = $this->sourceRepository->findAll();

        foreach ($sources as $source) {
            $name = $source->getUrl();

            $io->info("$name parsing...");

            $newsParser = new NewsParser($source);
            $this->messageBus->dispatch($newsParser);

            $io->info("$name parsing completed...");
        }


        $io->success('Parsing has been completed successfully!');

        return Command::SUCCESS;
    }
}
