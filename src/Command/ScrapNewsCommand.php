<?php

namespace App\Command;

use App\Message\NewsSourceEvenMessage;
use App\Message\NewsSourceOddMessage;
use App\Repository\NewsSourceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ScrapNewsCommand extends Command
{
    protected static $defaultName = 'app:scrap-news';
    protected static $defaultDescription = 'Add a short description for your command';
    private NewsSourceRepository $news_source_repository;
    private MessageBusInterface $bus;

    public function __construct(NewsSourceRepository  $news_source_repository, MessageBusInterface $bus)
    {
        parent::__construct(null);
        $this->news_source_repository = $news_source_repository;
        $this->bus = $bus;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $sources = $this->news_source_repository->findAll();
        foreach($sources as $source){
            if($source->getId()%2 == 0){
                $this->bus->dispatch(new NewsSourceEvenMessage($source));
            }else{
                $this->bus->dispatch(new NewsSourceOddMessage($source));
            }
        }

        $io->success('Scraping news.');

        return Command::SUCCESS;
    }
}
