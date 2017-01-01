<?php

namespace Mumbee\SmsModeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MumbeeSmsModeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mumbee_smsmode.url_envoi_sms', $config['url_envoi_sms']);
        $container->setParameter('mumbee_smsmode.url_compte_rendu_sms', $config['url_compte_rendu_sms']);
        $container->setParameter('mumbee_smsmode.url_solde_compte_client', $config['url_solde_compte_client']);
        $container->setParameter('mumbee_smsmode.url_creation_sous_compte_client', $config['url_creation_sous_compte_client']);
        $container->setParameter('mumbee_smsmode.url_suppression_sous_compte_client', $config['url_suppression_sous_compte_client']);
        $container->setParameter('mumbee_smsmode.url_suppression_sms', $config['url_suppression_sms']);
        $container->setParameter('mumbee_smsmode.url_liste_sms', $config['url_liste_sms']);
        $container->setParameter('mumbee_smsmode.url_statut_sms', $config['url_statut_sms']);
        $container->setParameter('mumbee_smsmode.url_liste_reponses_sms', $config['url_liste_reponses_sms']);
        $container->setParameter('mumbee_smsmode.url_transfert_credits', $config['url_transfert_credits']);
        $container->setParameter('mumbee_smsmode.url_ajout_contact', $config['url_ajout_contact']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
