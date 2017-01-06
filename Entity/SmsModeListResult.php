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
        $ar = explode("<br/>", $result);
        foreach($ar as trim($element)) {
            $ar2 = explode("|", $element);
            $this->items[] = $ar2;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

}
