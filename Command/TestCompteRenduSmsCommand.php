<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 28/12/16
 * Time: 21:51
 */

namespace Mumbee\SmsModeBundle\Command;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestCompteRenduSmsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestCompteRenduSmsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:compte_rendu')
            ->setDescription('Get SMS result')
            ->setHelp("This command allows you to get the SMS result")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode password account')
            ->addArgument('smsID', InputArgument::REQUIRED, 'SMS ID in the send result');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $smsID = $input->getArgument('smsID');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->compteRendu($pseudo, $password, $smsID);
        var_dump($result);die;
    }

}