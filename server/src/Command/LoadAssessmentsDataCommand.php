<?php declare(strict_types=1);

namespace App\Command;

use App\Service\AssessmentsLoaderService;
use Closure;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:load-assessments-data')]
final class LoadAssessmentsDataCommand extends Command
{
    public function __construct(
        private readonly AssessmentsLoaderService $initializerService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('Loading assessments data... ');

        $this->initializerService->load();

        $output->writeln('<info>done</info>');

        return Command::SUCCESS;
    }
}
