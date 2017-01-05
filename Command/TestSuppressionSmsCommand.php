<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 05/01/17
 * Time: 14:14
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeSimpleResult;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestSuppressionSmsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestSuppressionSmsCommand extends  ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:delete')
            ->setDescription('Supprimer un envoi SMS')
            ->setHelp("This command allows you to delete a SMS")
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
        $result = $smsService->supprimerSms($pseudo, $password, null,$smsId);
        $io = new SymfonyStyle($input, $output);
        if($result->getCode() == SmsModeSimpleResult::CODE_RETOUR_CREATION_EFFECTUEE) {
            $io->success(sprintf('La suppression du SMS %s a été effectué avec succès : code %s (%s)', $smsId, $result->getCode(), $result->getDescription()));
        }else{
            $io->warning(sprintf('La suppression a échouée : code %s (%s)', $result->getCode(), $result->getDescription()));
        }
    }

}