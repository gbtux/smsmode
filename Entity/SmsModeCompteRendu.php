<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 29/12/16
 * Time: 18:07
 */

namespace Mumbee\SmsModeBundle\Entity;


class SmsModeCompteRendu
{
    private $phoneNumber;

    private $statut;

    private $labelStatut;

    private $tabStatut = array(
      0 => "SMS envoyé",
      2 => "Erreur interne lors de l’envoi du SMS",
      11 => "SMS reçu par le téléphone portable",
      13 => "Délivré opérateur (SMS délivré à l’opérateur dont dépend votre destinataire)",
      34 => "Erreur routage (réseau du destinataire non reconnu)",
      35 => "Erreur réception (SMS non délivré par l’opérateur sur le téléphone du destinataire)"
    );

    public function __construct($entry)
    {
        $parsed = explode(" ", $entry);
        $this->phoneNumber = $parsed[0];
        $this->statut = $parsed[1];
        $this->labelStatut = $this->tabStatut[$parsed[1]];
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getLabelStatut()
    {
        return $this->labelStatut;
    }


}