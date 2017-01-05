<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 05/01/17
 * Time: 14:21
 */

namespace Mumbee\SmsModeBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestListerSmsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestListerSmsCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:list')
            ->setDescription('Lister les envois SMS')
            ->setHelp("This command allows you to list sent SMS")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode source pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode source password account')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $smsList = $smsService->listerSms($pseudo, $password);
        $io = new SymfonyStyle($input, $output);
        $io->table(array('smsId', 'date envoi', 'texte sms', 'téléphone destinataire', 'côut en crédit', 'nbre de destinatires'), $smsList->getItems());
    }

}