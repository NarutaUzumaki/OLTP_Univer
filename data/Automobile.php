<?php

//main table
class Automobile implements JsonSerializable {
    private $code;
    private $number;
    private $pass_place_count;
    private $code_owner;
    private $ownerName;
    private $code_park;
    private $parkName;
    private $codeBrend;
    private $autoBrend;

    function __construct(int $code, int $number, int $pass_place_count, int $code_owner, string $ownerName,  int $codeBrend, string $autoBrend, int $code_park, string $parkName){
        $this->code = $code;
        $this->number = $number;
        $this->pass_place_count = $pass_place_count;
        $this->code_owner = $code_owner;
        $this->ownerName = $ownerName;
        $this->code_park = $code_park;
        $this->parkName = $parkName;
        $this->codeBrend = $codeBrend;
        $this->autoBrend = $autoBrend;
    }

    function getCode(){
        return $this->code;
    }

    function getNumber(){
        return $this->number;
    }

    function getPassPlaceCount(){
        return $this->pass_place_count;
    }

    function getCodeOwner(){
        return $this->code_owner;
    }

    public function getOwnerName(){
        return $this->ownerName;
    }

    function getCodePark(){
        return $this->code_park;
    }

    public function getParkName(){
        return $this->parkName;
    }

    public function getCodeBrend(){
        return $this->codeBrend;
    }

    public function getAutoBrend(){
        return $this->autoBrend;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'number' => $this->number,
            'pass_place_count' => $this->pass_place_count,
            'ownerName' => $this->ownerName,
            'ownerCode' => $this->code_owner,
            'autoBrend' => $this->autoBrend,
            'brendCode' => $this->codeBrend,
            'code_park' => $this->code_park,
            'parkName' => $this->parkName
        ];
    }
}