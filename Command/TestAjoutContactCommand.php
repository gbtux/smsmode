<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 01/01/17
 * Time: 17:45
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeSimpleResult;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestAjoutContactCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestAjoutContactCommand extends ContainerAwareCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:contact:add')
            ->setDescription('Add contact')
            ->setHelp("This command allows you to add a contact")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode source pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode source password account')
            ->addArgument('nom', InputArgument::REQUIRED, 'contact name')
            ->addArgument('mobile', InputArgument::REQUIRED, 'contact mobile phone')
            ->addArgument('prenom', InputArgument::OPTIONAL, 'contact surname')
            ->addArgument('societe', InputArgument::OPTIONAL, 'societe')
            ->addArgument('groupes', InputArgument::IS_ARRAY, 'groupes')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $nom = $input->getArgument('nom');
        $prenom = $input->getArgument('prenom');
        $mobile = $input->getArgument('reference');
        $societe = $input->getArgument('societe');
        $groupes = $input->getArgument('societe');

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->ajouterContact($pseudo, $password, null, $nom, $mobile, $prenom, $societe, null, null, $groupes);
        $io = new SymfonyStyle($input, $output);
        if($result->getCode() == SmsModeSimpleResult::CODE_RETOUR_CREATION_EFFECTUEE) {
            $io->success(sprintf('Le contact %s a été créé avec succès : code %s (%s)', $nom, $result->getCode(), $result->getDescription()));
        }else{
            $io->warning(sprintf('La création a échouée : code %s (%s)', $result->getCode(), $result->getDescription()));
        }
    }

}