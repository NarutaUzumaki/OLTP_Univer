<?php


class Parking implements JsonSerializable {
    private $parkCode;
    private $parkName;
    private $parkPlaces;
    private $parkPlacesTake;

    function __construct(int $parkCode, string $parkName, int $parkPlaces, int $parkPlacesTake){
        $this->parkCode = $parkCode;
        $this->parkName = $parkName;
        $this->parkPlaces = $parkPlaces;
        $this->parkPlacesTake = $parkPlacesTake;
    }

    public function getParkCode()
    {
        return $this->parkCode;
    }

    public function getParkName()
    {
        return $this->parkName;
    }

    public function getParkPlaces()
    {
        return $this->parkPlaces;
    }

    public function getParkPlacesTake()
    {
        return $this->parkPlacesTake;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return[
            'parkCode' => $this->parkCode,
            'parkName' => $this->parkName,
            'parkPlaces' => $this->parkPlaces,
            'parkPlacesTake' => $this->parkPlacesTake
        ];
    }
}