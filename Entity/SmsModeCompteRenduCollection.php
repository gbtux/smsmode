<?php
/**
 * Created by PhpStorm.
 * User: gbtux
 * Date: 29/12/16
 * Time: 18:04
 */

namespace Mumbee\SmsModeBundle\Entity;

/**
 * Class SmsModeCompteRenduCollection
 * @package Mumbee\SmsModeBundle\Entity
 */
class SmsModeCompteRenduCollection
{
    private $collection = array();

    public function __construct($result)
    {
        $parsed = explode("|",$result);
        foreach($parsed as $entry) {
            if(count($entry) == 2){
                $this->collection[] = new SmsModeCompteRendu($entry);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    public function getArrayCollection()
    {
        $entries = array();

        foreach($this->collection as $cr) {
          $entries[] = array($cr->getPhoneNumber(), $cr->getStatut(), $cr->getLabelStatut());
        }
        return $entries;
    }



}