<?php

namespace Styxit\Commands;

use InvalidArgumentException;
use Styxit\AbstractSolution;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SolvePuzzleCommand extends Command
{
    /**
     * @var string The command name.
     */
    protected static $defaultName = 'solve';

    /**
     * Set command configuration.
     */
    protected function configure()
    {
        $this->setDescription('Solve a puzzle for a specific day.');
        $this->addArgument('day', InputArgument::REQUIRED, 'The day to solve.');
    }

    /**
     * Run the command.
     *
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument('day');

        // Get the solution class for the requested day.
        $solutionClass = $this->getDaySolution($day);

        // Create solution instance and run it.
        $solver = new $solutionClass();
        $solution = $solver->execute();

        $output->writeln('Solution: '.$solution);
    }

    /**
     * Get the Solution for  a day.
     *
     * @param int|string $day The day to solve.
     *
     * @return string The FQNS to the solution.
     */
    private function getDaySolution($day) : string
    {
        if (!is_numeric($day)) {
            throw new \InvalidArgumentException('No numeric day provided');
        }

        // Construct the namespace to the solution.
        $solutionClass = '\Days\Day'.$day.'\Solution';

        if (!class_exists($solutionClass)) {
            throw new InvalidArgumentException('No solution found for day '.$day);
        }

        return $solutionClass;
    }
}