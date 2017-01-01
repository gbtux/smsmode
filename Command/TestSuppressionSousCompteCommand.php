<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 01/01/17
 * Time: 14:39
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeCreationResult;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestSuppressionSousCompteCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestSuppressionSousCompteCommand extends ContainerAwareCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:compte:delete')
            ->setDescription('Delete a sub account')
            ->setHelp("This command allows you to delete a sub/ customer account")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode pseudo principal account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode password principal account')
            ->addArgument('pseudoToDelete', InputArgument::REQUIRED, 'account pseudo to delete')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $pseudoToDelete = $input->getArgument('pseudoToDelete');
        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->supprimerSousCompte($pseudo, $password, null, $pseudoToDelete);
        $io = new SymfonyStyle($input, $output);
        if($result->getCode() == SmsModeCreationResult::CODE_RETOUR_CREATION_EFFECTUEE) {
            $io->success(sprintf('Le compte %s a été supprimé avec succès : code %s (%s)', $pseudoToDelete, $result->getCode(), $result->getDescription()));
        }else{
            $io->warning(sprintf('La suppression du compte %s a échouée : code %s (%s)', $pseudoToDelete, $result->getCode(), $result->getDescription()));
        }
    }

}