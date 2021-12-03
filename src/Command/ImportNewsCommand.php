<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\News;
use App\Service\NewsApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportNewsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NewsApiService $newsApiService,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:import-news')
            ->setDescription('Import news from newsapi.org')
            ->setHelp('This command allows you to import news from newsapi.org');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($articles = $this->newsApiService->getNews()->articles
            as $article) {
            $news = new News();
            $news->setTitle($this->stripSource($article->title));
            $news->setDescription($article->description);
            $news->setUrl($this->limitUrlLength($article->url));
            $news->setPublishedAt(new \DateTime($article->publishedAt));
            $news->setContent($article->content);
            $news->setImage($this->limitUrlLength($article->urlToImage));

            $this->entityManager->persist($news);
        }

        $this->entityManager->flush();

        if ($count = count($articles)) {
            $output->writeln("<fg=green>$count news articles imported</>");
            return Command::SUCCESS;
        }

        $output->writeln('<fg=red>no news articles found</>');
        return Command::FAILURE;
    }

    private function stripSource(string $url): string
    {
        foreach ([' - ', ' | ', ' – '] as $char) {
            if (false !== $pos = strpos($url, $char)) {
                $url = substr($url, 0, $pos);
            }
        }

        return $url;
    }

    private function limitUrlLength(string|null $value): string|null
    {
        return $value && strlen($value) <= 255 ? $value : null;
    }
}
