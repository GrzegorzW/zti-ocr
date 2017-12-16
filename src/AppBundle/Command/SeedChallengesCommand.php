<?php

declare(strict_types = 1);

namespace AppBundle\Command;

use AppBundle\Repository\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedChallengesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:seed-challenges');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Seed database',
            '============',
            '',
        ]);

        /** @var ChallengeRepository $challengeRepository */
        $challengeRepository = $this->getContainer()->get('app.challenge_repository');

//        while (1) {
            $challengeRepository->bulkRandomInsert(100);
//        }

        $challengeRepository = $this->getContainer()->get('app.answer_manager');

    }
}
