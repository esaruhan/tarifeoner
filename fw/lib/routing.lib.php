<?php

/*
 * ozgur kuru november 2011 
 */

class routing {

    private $request;
    private $pieces;
    private $MasterPage;
    private $SubPage = false;
    private $SubPageValue;
    private $piece_count;
    private $routing_data;
    public $id;

    function __construct() {
        $this->request = $_SERVER["REQUEST_URI"];
        $this->pieces = explode("/", $this->request);
        if (count($this->pieces) > 2) {
            $this->SubPageValue = $this->pieces[2];
            $this->SubPage = true;
        }

        foreach ($this->pieces as $key => $value) {
            if (is_numeric($value)) {
                $this->id = $value;
                break;
            }
        }

        $debug = array_search("debug", $this->pieces);
        if ($debug >= 1) {
            $this->debug = true;
        }
        $this->MasterPage = $this->pieces[1];

        $this->piece_count = count($this->pieces);
    }

    function Router() {
        $this->routing_data = array("master" => $this->MasterPage, "sub" => $this->SubPageValue, "id" => $this->id, "debug" => $this->debug);
        return $this->routing_data;
    }

}

?>
