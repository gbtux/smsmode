<?php

namespace Mumbee\SmsModeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mumbee_sms_mode');


        $rootNode->children()
                    ->scalarNode('url_envoi_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/sendSMS.do')
                        ->end()
                    ->scalarNode('url_compte_rendu_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/compteRendu.do')
                        ->end()
                    ->scalarNode('url_solde_compte_client')
                        ->defaultValue('https://api.smsmode.com/http/1.6/credit.do')
                        ->end()
                    ->scalarNode('url_creation_sous_compte_client')
                        ->defaultValue('https://api.smsmode.com/http/1.6/createSubAccount.do')
                        ->end()
                    ->scalarNode('url_suppression_sous_compte_client')
                        ->defaultValue('https://api.smsmode.com/http/1.6/deleteSubAccount.do')
                        ->end()
                    ->scalarNode('url_suppression_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/deleteSMS.do')
                        ->end()
                    ->scalarNode('url_liste_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/smsList.do')
                        ->end()
                    ->scalarNode('url_statut_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/smsStatus.do')
                        ->end()
                    ->scalarNode('url_liste_reponses_sms')
                        ->defaultValue('https://api.smsmode.com/http/1.6/responseList.do')
                        ->end()
                    ->scalarNode('url_transfert_credits')
                        ->defaultValue('https://api.smsmode.com/http/1.6/creditTransfert.do')
                        ->end()
                    ->scalarNode('url_ajout_contact')
                        ->defaultValue('https://api.smsmode.com/http/1.6/addContact.do')
                        ->end()
                 ->end()
        ;
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
