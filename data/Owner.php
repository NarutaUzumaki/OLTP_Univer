<?php


class Owner{
    private $code;
    private $last_name;

    function __construct(int $code, string $last_name){
        $this->code = $code;
        $this->last_name = $last_name;
    }

    function getCode(){
        return $this->code;
    }

    function getLastName(){
        return $this->last_name;
    }
}