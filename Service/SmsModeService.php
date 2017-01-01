<?php
/**
 * User: gbtux
 * Date: 17/12/16
 * Time: 19:54
 */

namespace Mumbee\SmsModeBundle\Service;

use Mumbee\SmsModeBundle\Entity\SmsModeCreationResult;
use Mumbee\SmsModeBundle\Entity\SmsModeResult;
use Mumbee\SmsModeBundle\Entity\SmsModeCompteRenduCollection;

/**
 * Class SmsModeService
 * @package Mumbee\SmsModeBundle\Service
 */
class SmsModeService
{
    /**
     * @var
     */
    private $urlEnvoiSms;

    /**
     * @var
     */
    private $urlCompteRenduSms;

    /**
     * @var
     */
    private $urlSoldeCompteClient;

    /**
     * @var
     */
    private $urlCreationSousCompteClient;

    /**
     * @var
     */
    private $urlSuppressionSousCompteClient;

    /**
     * @var
     */
    private $urlSuppressionSms;

    /**
     * @var
     */
    private $urlListeSms;

    /**
     * @var
     */
    private $urlStatutSms;

    /**
     * @var
     */
    private $urlListeReponsesSms;

    /**
     * @var
     */
    private $urlTransfertCredits;

    /**
     * Constructor
     * @param $urlEnvoiSms
     * @param $urlCompteRenduSms
     * @param $urlSoldeCompteClient
     */
    public function __construct($urlEnvoiSms, $urlCompteRenduSms, $urlSoldeCompteClient, $urlCreationSousCompteClient,
                                $urlSuppressionSousCompteClient, $urlSuppressionSms, $urlListeSms, $urlStatutSms, $urlListeReponsesSms,
                                $urlTransfertCredits)
    {
        $this->urlEnvoiSms = $urlEnvoiSms;
        $this->urlCompteRenduSms = $urlCompteRenduSms;
        $this->urlSoldeCompteClient = $urlSoldeCompteClient;
        $this->urlCreationSousCompteClient = $urlCreationSousCompteClient;
        $this->urlSuppressionSousCompteClient = $urlSuppressionSousCompteClient;
        $this->urlSuppressionSms = $urlSuppressionSms;
        $this->urlListeSms = $urlListeSms;
        $this->urlStatutSms = $urlStatutSms;
        $this->urlListeReponsesSms = $urlListeReponsesSms;
        $this->urlTransfertCredits = $urlTransfertCredits;
    }

    /**
     * @param $pseudo : pseudo du compte client (non obligatoire si utilisation de l'accessToken)
     * @param $pass : password du compte client (non obligatoire si utilisation de l'accessToken)
     * @param $message : message non formatté
     * @param array $numeros : array de numeros
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @param null $emetteur : chaine affichée comme émetteur du SMS
     * @param null $groupe : si numeros vides : identifiant du groupe de numeros renseigné sur SMSMode
     * @param int $classeMsg : 2 par défaut ou 4 avec réponse autorisée
     * @param null $stop : 1 pour intégrer STOP SMS si pas de conso en +, 2 quelle que soit la conso en plus, non envoyé par défaut
     * @param \DateTime|null $dateEnvoi : si envoi non simultanné
     * @param null $refClient : utilisé en cas de compte-rendu automatique (ex : ID client en BDD)
     * @param null $notificationUrl : URL de callback lors d'un changement de statut du SMS
     * @param null $notificationUrlReponse : : URL de callback lors d'une réponse à un SMS (si classeMsg == 4)
     * @return SmsModeResult
     * @throws \Exception
     */
    public function envoyerSms($pseudo, $pass, $message,
                               array $numeros, $accessToken=null, $emetteur = null, $groupe = null, $classeMsg = 2, $stop = null,
                                \DateTime $dateEnvoi = null, $refClient = null, $notificationUrl = null, $notificationUrlReponse = null                            )
    {
        $texte = mb_convert_encoding($message, "ISO-8859-15", "auto");
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }
        $fields .= sprintf('&message=%s', urlencode($texte));
        if((null == $numeros && null == $groupe) || empty($numeros))
            throw new \Exception('Numero ou groupe obligatoire et numero non vide');

        if(null != $numeros && !empty($numeros)){
            $phones = implode(',', $numeros);
            $fields .= sprintf('&numero=%s', $phones);
        }

        if(null == $numeros && null != $groupe)
            $fields .= sprintf('&groupe=%s', $groupe);

        if($classeMsg != 2 && $classeMsg == 4)
            $fields .= "&classe_msg=4";

        if($dateEnvoi != null)
            $fields .= sprintf('&date_envoi=%s', $dateEnvoi->format('dmY-H:i')); //ddmmyyyy-hh:mm

        if(null != $emetteur && sizeof($emetteur) <12 && $classeMsg == 2)
            $fields .= sprintf('&emetteur=%s', $emetteur);

        if($stop == 1 || $stop == 2)
            $fields .= sprintf('&stop=%d', $stop);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlEnvoiSms);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);

        curl_close($ch);
        return new SmsModeResult($result);
    }

    /**
     * Get the "compte rendu" of a sms sent
     * @param $pseudo
     * @param $pass
     * @param $smsID : ID de l'envoi SMS (renvoye par la methode envoyerSms)
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @return SmsModeCompteRenduCollection : array of SmsModeCompteRendu
     */
    public function compteRendu($pseudo, $pass, $smsID, $accessToken=null)
    {
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }
        $fields .= sprintf('&smsID=%s', $smsID);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlCompteRenduSms);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return new SmsModeCompteRenduCollection($result);
    }

    /**
     * Retourne le solde du compte client
     * @param $pseudo : pseudo du compte principal
     * @param $pass : password du compte principal
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @return mixed
     */
    public function soldeCompteClient($pseudo, $pass, $accessToken=null)
    {
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlSoldeCompteClient);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Creer un sous compte client
     * @param $pseudo : pseudo du compte principal
     * @param $pass : password du compte principal
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @param $newPseudo : pseudo du sous compte
     * @param $newPassword : password du sous compte
     * @param null $reference : optionnel si on veut garder une reference du compte
     * @return SmsModeCreationResult
     * @throws \Exception : si newPseudo > 50 caracteres
     */
    public function creerSousSompte($pseudo, $pass, $accessToken=null, $newPseudo, $newPassword, $reference = null)
    {
        if(strlen($newPseudo > 50))
            throw new \Exception("Max lenght of new pseudo is 50 characters");
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }
        $fields .= sprintf('&newPseudo=%s', $newPseudo);
        $fields .= sprintf('&newPass=%s', $newPassword);

        if(null != $reference){
            $fields .= sprintf('&reference=%s', $reference);
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlCreationSousCompteClient);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return new SmsModeCreationResult($result);
    }

    /**
     * Supprimer un sous compte client
     * @param $pseudo : pseudo du compte principal
     * @param $pass : password du compte principal
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @param $pseudoToDelete : pseudo du sous compte à supprimer
     * @return SmsModeCreationResult
     */
    public function supprimerSousCompte($pseudo, $pass, $accessToken=null, $pseudoToDelete)
    {
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }
        $fields .= sprintf('&pseudoToDelete=%s', $pseudoToDelete);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlSuppressionSousCompteClient);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return new SmsModeCreationResult($result);
    }

    /**
     * @param $pseudo : pseudo du compte à debiter
     * @param $pass : password du compte à débiter
     * @param null $accessToken : si authentification par token (pseudo et pass optionnel dans ce cas)
     * @param $targetPseudo : pseudo du compte à crediter
     * @param int $credits : nombre de credits à créditer (entier)
     */
    public function transfererCredits($pseudo, $pass, $accessToken=null,$targetPseudo, int $credits, $reference=null)
    {
        $fields = "";
        if(null != $accessToken){
            $fields = sprintf('accessToken=%s', $accessToken);
        }else{
            $fields = sprintf('pseudo=%s&pass=%s', $pseudo, $pass);
        }
        $fields .= sprintf('&targetPseudo=%s', $targetPseudo);
        $fields .= sprintf('&creditAmount=%d', $credits);
        if(null != $reference){
            $fields .= sprintf('&reference=%s', $reference);
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->urlTransfertCredits);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}