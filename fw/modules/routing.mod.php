<?php

/*
 * ozgurkuru november 2011
 */

class routes {

    private $routing_data;
    private $master;
    private $sub;
    private $id;

    function __construct($routing_data) {

        $this->routing_data = $routing_data;
        $this->master = $this->routing_data["master"];
        $this->sub = $this->routing_data["sub"];
        $this->id = $this->routing_data["id"];
        $this->debug=$this->routing_data["debug"];
    }

    function getMaster() {
        return $this->master;
    }
    function getId(){
        return $this->id;
    }
    function getSub() {
        return $this->sub;
    }
    
    function getDebug(){
        return $this->debug;
    }

}

?>
