<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 06/01/17
 * Time: 10:50
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeStateResult;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestStatutSmsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestStatutSmsCommand extends  ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:status')
            ->setDescription("Statut d'un envoi SMS")
            ->setHelp("This command allows you to get a SMS status")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode source pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode source password account')
            ->addArgument('smsID', InputArgument::REQUIRED, 'SMS ID reference')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $smsId = $input->getArgument('smsID');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->statutSms($pseudo, $password, null,$smsId);
        $io = new SymfonyStyle($input, $output);
        if($result->getCode() == SmsModeStateResult::CODE_RETOUR_ENVOYE) {
            $io->success(sprintf('Le SMS %s a été envoyé avec succès : code %s (%s)', $smsId, $result->getCode(), $result->getDescription()));
        }else{
            $io->warning(sprintf("L'envoi de SMS n'est pas finalisé : code %s (%s)", $result->getCode(), $result->getDescription()));
        }
    }

}