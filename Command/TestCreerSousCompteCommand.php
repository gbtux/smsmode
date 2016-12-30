<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 30/12/16
 * Time: 13:14
 */

namespace Mumbee\SmsModeBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestCreerSousCompteCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestCreerSousCompteCommand extends ContainerAwareCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:compte:create')
            ->setDescription('Create a sub account')
            ->setHelp("This command allows you to create a sub/ customer account")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode pseudo principal account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode password principal account')
            ->addArgument('newpseudo', InputArgument::REQUIRED, 'pseudo for the new account')
            ->addArgument('newpassword', InputArgument::REQUIRED, 'password for the new account')
            ->addArgument('reference', InputArgument::OPTIONAL, 'optionnal reference for the new account')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $newPseudo = $input->getArgument('newpseudo');
        $newPassword = $input->getArgument('newpassword');
        $reference = $input->getArgument('reference');
        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->creerSousSompte($pseudo, $password, null, $newPseudo, $newPassword, $reference);
        $io = new SymfonyStyle($input, $output);
        $io->success($result);
    }

}