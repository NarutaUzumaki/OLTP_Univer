<?php


class CarList implements JsonSerializable {
    private $code;
    private $automobile;
    private $passPlaces;
    private $number;
    private $ownerName;
    private $codeOwner;
    private $autoBrend;
    private $codeBrend;

    private $parking;
    private $rows = [];


    function __construct(int $code, Automobile $automobile = null, Brend $brend = null, Owner $owner = null, Parking $parking = null){
        $this->code = $code;
//        $this->automobile = $automobile;
//        $this->brend = $brend;
//        $this->owner = $owner;
    }

    function getAutomobile(){
        return $this->automobile;
    }

    function getRows(){
        return $this->rows;
    }

    public function getCodeOwner()
    {
        return $this->codeOwner;
    }

    public function getCodeBrend()
    {
        return $this->codeBrend;
    }

    public function getPassPlaces()
    {
        return $this->passPlaces;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getAutoBrend()
    {
        return $this->autoBrend;
    }

    public function getOwnerName()
    {
        return $this->ownerName;
    }

    public function setPassPlaces($passPlaces)
    {
        $this->passPlaces = $passPlaces;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function setOwnerName($ownerName)
    {
        $this->ownerName = $ownerName;
    }

    public function setAutoBrend($autoBrend)
    {
        $this->autoBrend = $autoBrend;
    }

    public function setCodeBrend($codeBrend)
    {
        $this->codeBrend = $codeBrend;
    }

    public function setCodeOwner($codeOwner)
    {
        $this->codeOwner = $codeOwner;
    }

    public function setAutomobile($automobile)
    {
        $this->automobile = $automobile;
    }

    function readFromDB(){
        $db = new DB();

        $res = $db->runSP('getReadingData',[
            [$this->code, 'in']
        ]);
        if (!$res){
            return $res;
        }


        $park_head = $res[1];
        $this->parking = new Parking($park_head[0]['code'],$park_head[0]['name'],$park_head[0]['park_place_count'],$park_head[0]['car_quantity']);


        $carList = $res[0];
            foreach ($carList as $row){
                $this->rows[] = new Automobile($row['acode'], $row['number'], $row['pass_place_count'], $row['ocode'], $row['last_name'], $row['bcode'], $row['auto_brend'],$row['code_park'], $row['name']);
            }
        return true;
    }

    public function jsonSerialize()
    {
        return[
            'parking' => $this->parking,
            'rows' => $this->rows,
            'automobile' => $this->automobile,
        ];
    }

    function readRowFromDB(){
        $db = new DB();

        $res = $db->runSP('getReadingDataRow',[
            [$this->code, 'in']
        ]);
        if (!$res){
            return $res;
        }
        $row = $res[0];

        $this->automobile = new Automobile($row[0]['acode'], $row[0]['number'], $row[0]['pass_place_count'], $row[0]['ocode'], $row[0]['last_name'], $row[0]['bcode'], $row[0]['auto_brend'],$row[0]['code_park'], $row[0]['name']);
        return true;
    }

    function remFromDB(){
        $db = new DB();

        $stat = 0;
        $db->runSP('removeDataFromDB',[
            [$this->code, 'in'],
            [&$stat, 'out']
        ]);
        return(bool)$stat;
    }

    function writeToDB(){
        //done;Шаблон для String "...'".$this->String."'..."
        $db = new DB();
        $stat = 0;
        $db->runSP('writeDataToDB',[
            [$this->passPlaces, 'in'],
            [$this->code, 'in'],
            [$this->autoBrend, 'in'],
            [$this->codeBrend, 'in'],
            [$this->ownerName, 'in'],
            [$this->codeOwner, 'in'],
            [&$stat, 'out']
        ]);
        return(bool)$stat;
    }

    function insertToDB(){
        $db = new DB();

        $stat = 0;
        $db->runSP('insertDataToDB',[
            [$this->getAutomobile()->getOwnerName(), 'in'],
            [$this->getAutomobile()->getNumber(), 'in'],
            [$this->getAutomobile()->getPassPlaceCount(), 'in'],
            [$this->getAutomobile()->getAutoBrend(), 'in'],
            [&$stat, 'out']
        ]);
        return(bool)$stat;
    }
}
