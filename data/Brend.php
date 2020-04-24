<?php


class Brend{
    private $code;
    //private $code_car;
    private $auto_brend;

    function __construct(int $code, string $auto_brend){
        $this->code = $code;
        //$this->code_car = $code_car;
        $this->auto_brend = $auto_brend;
    }

    function getCode(){
        return $this->code;
    }

    function  getCodeCar(){
        return $this->code_car;
    }

    function getAutoBrend(){
        return $this->auto_brend;
    }
}