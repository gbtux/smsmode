<?php
/**
 * User: gbtux
 * Date: 28/12/16
 * Time: 15:44
 */

namespace Mumbee\SmsModeBundle\Entity;

/**
 * Class SmsModeResult
 * @package Mumbee\SmsModeBundle\Entity
 */
class SmsModeResult
{
    const CODE_RETOUR_ACCEPTE = '0';
    const CODE_RETOUR_ERREUR_INTERNE = '31';
    const CODE_RETOUR_ERREUR_AUTHENTIFICATION = '32';
    const CODE_RETOUR_CREDITS_INSUFFISANTS = '33';
    const CODE_RETOUR_PARAMETRE_MANQUANT = '35';
    const CODE_RETOUR_TEMP_INACCESSIBLE = '50';

    /**
     * @var $code : code de retour
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $smsID : identifiant de l'envoi
     */
    private $smsID;


    public function __construct($result)
    {
        $parsed = explode(" | ", $result);
        $this->code = $parsed[0];
        $this->description = $parsed[1];
        $this->smsID = $parsed[2];
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSmsID()
    {
        return $this->smsID;
    }

    /**
     * @param string $smsID
     */
    public function setSmsID($smsID)
    {
        $this->smsID = $smsID;
    }



}