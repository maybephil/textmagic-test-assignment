<?php declare(strict_types=1);

namespace App\Command;

use App\Service\AppInitializerService;
use Closure;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:initialize')]
final class AppInitializeCommand extends Command
{
    /**
     * @var array<string, Closure>
     */
    private readonly array $initializationSteps;

    public function __construct(
        private readonly AppInitializerService $initializerService,
    ) {
        parent::__construct();

        $this->initializationSteps = [
            'Loading assessments data... ' => fn () => $this->initializerService->loadAssessmentsData(),
            'Mark application as initialized... ' => fn () => $this->initializerService->markAppAsInitialized(),
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'App initialization',
            '==================',
            '',
        ]);

        if ($this->initializerService->isAppInitialized()) {
            $output->writeln('<info>App is already initialized.</info>');
            return Command::SUCCESS;
        }

        foreach ($this->initializationSteps as $description => $action) {
            $output->write($description);

            $action();

            $output->write('<info>done</info>');
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}
