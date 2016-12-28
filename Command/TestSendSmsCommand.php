<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 18/12/16
 * Time: 17:14
 */

namespace Mumbee\SmsModeBundle\Command;

use Mumbee\SmsModeBundle\Entity\SmsModeResult;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestSendSmsCommand
 * @package Mumbee\SmsModeBundle\Command
 */
class TestSendSmsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mumbee:sms:send')
            ->setDescription('Send SMS.')
            ->setHelp("This command allows you to send SMS to gsm numbers...")
            ->addArgument('pseudo', InputArgument::REQUIRED, 'smsmode pseudo account')
            ->addArgument('password', InputArgument::REQUIRED, 'smsmode password account')
            ->addArgument('numbers', InputArgument::IS_ARRAY, '(separate phone numbers with a space)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $phones = null;
        $pseudo = $input->getArgument('pseudo');
        $password = $input->getArgument('password');
        $numbers = $input->getArgument('numbers');

        if (count($numbers) < 1)
            throw new RuntimeException('numbers is mandatory : you need to pass at least 1 phone number...');

        //$phones .= implode(',', $numbers);

        $smsService = $this->getContainer()->get('mumbee_smsmode');
        $result = $smsService->envoyerSms($pseudo, $password, 'Ceci est un message de test du MumbeeSMSModeBundle', $numbers, 'MUMBEE');
        $io = new SymfonyStyle($input, $output);
        if($result->getCode() == SmsModeResult::CODE_RETOUR_ACCEPTE){
            $io->success(sprintf("SMS envoyé avec l'ID %s", $result->getSmsID()));
        }else{
            $io->error(sprintf("L'erreur avec le code %s (%s) est apparue lors de l'envoi (ID : %s)", $result->getCode(), $result->getDescription(), $result->getSmsID()));
        }
    }

}
