<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 06/01/17
 * Time: 10:36
 */

namespace Mumbee\SmsModeBundle\Entity;


class SmsModeStateResult
{
    const CODE_RETOUR_ENVOYE = '0';
    const CODE_RETOUR_NON_ENVOYE_ERREUR_INTERNE = '2';
    const CODE_RETOUR_ENVOI_PROGRAMME = 10;
    const CODE_RETOUR_RECU = '11'; //(seulement si compte-rendu a été sélectionné, sinon “Envoyé”)
    const CODE_RETOUR_DELIVRE = '14'; //(seulement si compte-rendu a été sélectionné, sinon “Envoyé”)
    const CODE_RETOUR_ERREUR_AUTHENTIFICATION = '32'; //(“pseudo” et/ou “mot de passe” inexistants)
    const CODE_RETOUR_PARAMETRE_INCORRECT = '35'; //(“pseudo”, “pass”, “smsID” obligatoires)
    const CODE_RETOUR_SMSID_INVALIDE = '61';
    const CODE_RETOUR_ERREUR_RECEPTION = '39';
    const CODE_RETOUR_ERREUR_TEMPORAIRE_OPERATEUR = '3501';
    const CODE_RETOUR_ERREUR_TEMPORAIRE_ABSENCE = '3502';
    const CODE_RETOUR_ERREUR_TEMPORAIRE_TELEPHONE = '3503';
    const CODE_RETOUR_ERREUR_PERMANENTE_OPERATEUR = '3521';
    const CODE_RETOUR_ERREUR_PERMANENTE_ABSENCE = '3522';
    const CODE_RETOUR_ERREUR_PERMANENTE_TELEPHONE = '3523';
    const CODE_RETOUR_ERREUR_PERMANENTE_ANTI_SPAM = '3524';
    const CODE_RETOUR_ERREUR_PERMANENTE_CONTENU = '3525';
    const CODE_RETOUR_ERREUR_PERMANENTE_PORTABILITE = '3526';
    const CODE_RETOUR_ERREUR_PERMANENTE_ROAMING = '3527';
    const CODE_RETOUR_ERREUR_AUTRE = '3599';
    const CODE_RETOUR_NUMERO_INVALIDE = '3998';
    const CODE_RETOUR_DESTINATAIRE_BLACKLISTE = '3999';


    /**
     * @var $code : code de retour
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;


    public function __construct($unparsed)
    {
        $parsed = explode(" | ", $unparsed);
        $this->code = $parsed[0];
        $this->description = $parsed[1];
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }



}