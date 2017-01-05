<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 05/01/17
 * Time: 23:59
 */

namespace Mumbee\SmsModeBundle\Entity;


class SmsModeListResult
{

    private $items = array();

    public function __construct($result)
    {
        $this->items = explode("<br/>", $result);
        //$ar = explode("<br/>", $result);
        /*foreach($ar as $element){
            $ar2 = explode("|",$element);
            $item = array(); // smsId | date_envoi | texte_sms | téléphone_destinataire | coût_en_crédit | nbre_de_destinataires |
            $item['smsId'] = $ar2[0];
            $item['date_envoi'] = $ar2[1];
            $item['texte_sms'] = $ar2[2];
            $item['telephone'] = $ar2[3];
            $item['cout'] = $ar2[4];
            $item['nbre_destinataires'] = $ar2[5];
            $this->items[] = $item;
        }*/
    }

    public function getItems()
    {
        return $this->items;
    }

}