<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 01/01/17
 * Time: 16:14
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeCreationResult;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestTransfertCreditsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestTransfertCreditsCommand extends ContainerAwareCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:transfert')
            ->setDescription('Transfert credits')
            ->setHelp("This command allows you to transfert credits from an account to another")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode source pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode source password account')
            ->addArgument('targetPseudo', InputArgument::REQUIRED, 'account pseudo where to put credits')
            ->addArgument('credits', InputArgument::REQUIRED, 'account pseudo where to put credits')
            ->addArgument('reference', InputArgument::OPTIONAL, 'account pseudo where to put credits')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $targetPseudo = $input->getArgument('targetPseudo');
        $credits = $input->getArgument('credits');
        $reference = $input->getArgument('reference');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->transfererCredits($pseudo, $password, null, $targetPseudo, $credits, $reference);
        $io = new SymfonyStyle($input, $output);
        $io->success($result);
    }

}