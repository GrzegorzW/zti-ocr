<?php

declare(strict_types = 1);

namespace AppBundle\Command;

use AppBundle\Entity\Challenge;
use AppBundle\Repository\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedAnswersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:seed-answers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Seed database - answers',
            '============',
            '',
        ]);

        $answerRepository = $this->getContainer()->get('app.answer_repository');

        /** @var ChallengeRepository $challengeRepository */
        $challengeRepository = $this->getContainer()->get('app.challenge_repository');

        while (1) {
            /** @var Challenge $challenge */
            $challenge = $challengeRepository->getRandom();

            $answerRepository->bulkRandomInsert($challenge, 100);
        }
    }
}
