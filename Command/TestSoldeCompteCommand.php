<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 29/12/16
 * Time: 21:19
 */

namespace Mumbee\SmsModeBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestSoldeCompteCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestSoldeCompteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:solde')
            ->setDescription('Get balance account')
            ->setHelp("This command allows you to get the account balance")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode password account');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $solde = $smsService->soldeCompteClient($pseudo, $password);

        $io = new SymfonyStyle($input, $output);
        $io->success('Le solde du compte est de : ' .$solde);
    }

}