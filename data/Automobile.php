<?php

//main table
class Automobile implements JsonSerializable {
    private $code; //код машини з таблиці automobiles
    private $number; //номер машини з таблиці automobiles
    private $pass_place_count; // кілкість пасажирських мість з таблиці automobiles
    private $code_owner; //код власника машини з таблиці owners та в таблиці automobiles
    private $ownerName; //ім'я власника машини з таблиці owners
    private $code_park; //код парку з таблиці car_park у якому машину припарковано
    private $parkName; //назва парку з таблиці car_park
    private $codeBrend; //код машини з таблиці brends(посилається на код у таблицю automobiles)
    private $autoBrend; //марка машини з таблиці brends

    //                        1            2               3                     4                  5                  6                 7               8                  9
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