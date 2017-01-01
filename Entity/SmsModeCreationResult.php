<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 01/01/17
 * Time: 12:08
 */

namespace Mumbee\SmsModeBundle\Entity;


class SmsModeCreationResult
{

    const CODE_RETOUR_CREATION_EFFECTUEE = '0';
    const CODE_RETOUR_ERREUR_INTERNE = '31';
    const CODE_RETOUR_ERREUR_AUTHENTIFICATION = '32';
    const CODE_RETOUR_ERREUR_PARAMETRES_INCORRECTS = '35';
    const CODE_RETOUR_ERREUR_IDENTIFIANT_EXISTANT = '41';

    /**
     * 0
    Création effectuée
    31
    Erreur interne
    32
    Erreur d’authentification
    35
    Paramètres incorrects
    41
    Identifiant déjà existant
     */

    /**
     * @var $code : code de retour
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;

    public function __construct($result)
    {
        $parsed = explode(" | ", $result);
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

}