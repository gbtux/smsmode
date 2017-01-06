<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 06/01/17
 * Time: 14:00
 */

namespace Mumbee\SmsModeBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestListerReponsesCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestListerReponsesCommand extends  ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:answers')
            ->setDescription('Lister les réponses à un envoi SMS')
            ->setHelp("This command allows you to list answers of a SMS")
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
        $result = $smsService->listerReponses($pseudo, $password);
        $io = new SymfonyStyle($input, $output);
        var_dump($result);die;
    }

}