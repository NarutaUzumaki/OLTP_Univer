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

        $sql = 'select code, name, park_place_count, car_quantity from car_park
                where code = ' . $this->code;
        $park_head = $db->makeQuery($sql);
        if(!$park_head || !$park_head[0]){
            return false;
        }
        $this->parking = new Parking($park_head[0]['code'],$park_head[0]['name'],$park_head[0]['park_place_count'],$park_head[0]['car_quantity']);

        //var_dump($this->code);//null
        $sql = 'select automobiles.code acode, number, pass_place_count, brends.code bcode, auto_brend, owners.code ocode, last_name, automobiles.code_park, car_park.name
                from automobiles
                inner join owners on automobiles.code_owner = owners.code
                inner join brends on automobiles.code = brends.code_car
                inner join car_park on automobiles.code_park = car_park.code
                where automobiles.code_park = ' . $this->code;

        if ($carList = $db->makeQuery($sql)){
            foreach ($carList as $row){
                //var_dump($row['code']);
                $this->rows[] = new Automobile($row['acode'], $row['number'], $row['pass_place_count'], $row['ocode'], $row['last_name'], $row['bcode'], $row['auto_brend'],$row['code_park'], $row['name']);
            }
        }
        //var_dump($this->rows);
        //var_dump($this->rows);
        return $this->rows;
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
        $sql = 'select automobiles.code acode, number, pass_place_count, brends.code bcode, auto_brend, owners.code ocode, last_name, automobiles.code_park, car_park.name
                from automobiles
                inner join owners on automobiles.code_owner = owners.code
                inner join brends on automobiles.code = brends.code_car
                inner join car_park on automobiles.code_park = car_park.code
                where automobiles.code = '. $this->code;
        $row = $db->makeQuery($sql);
        if(!$row || !$row[0]){
            var_dump('Fail');
            return false;
        }
        $this->automobile = new Automobile($row[0]['acode'], $row[0]['number'], $row[0]['pass_place_count'], $row[0]['ocode'], $row[0]['last_name'], $row[0]['bcode'], $row[0]['auto_brend'],$row[0]['code_park'], $row[0]['name']);
/*        echo "<script>console.log(<?php $this->automobile; ?>)</script>";*/
        return true;
    }

    function remFromDB(){
        $db = new DB();
        $sqlDeleteBrend = 'delete from brends where code_car = '.$this->code;
        $db->runCommand($sqlDeleteBrend);

        $sqlForOwnerCode = 'select code_owner from automobiles where code = '.$this->code;
        $codeOwnerArr = $db->makeQuery($sqlForOwnerCode);
        $codeOwner = $codeOwnerArr[0]['code_owner'];

        $sqlDeleteAuto = 'delete from automobiles where code = '. $this->code;
        $db->runCommand($sqlDeleteAuto);

        //$sqlForOwnerCode = 'select code_owner from automobiles where code = '.$this->code;
        $sqlDeleteOwner = 'delete from owners where code = '.$codeOwner;
        //brend
        //auto
        //owner
        return $db->runCommand($sqlDeleteOwner);
    }

    function writeToDB(){
        //done;Шаблон для String "...'".$this->String."'..."
        $db = new DB();

        $sqlForAuto = 'update automobiles set pass_place_count = '.$this->passPlaces.' where code = '.$this->code;

        $sqlForBrend = "update brends set auto_brend = '".$this->autoBrend."' where code = ".$this->codeBrend;

        $sqlForOwner = "update owners set last_name = '".$this->ownerName."' where code = ".$this->codeOwner;

//        if ($db->runCommand($sqlForAuto) && $db->runCommand($sqlForBrend) && $db->runCommand($sqlForOwner)) {
////            $db->runCommand($sqlForAuto);
////            $db->runCommand($sqlForBrend);
////            $db->runCommand($sqlForOwner);
//            return true;
////            return $db->runCommand($sql);//runCommand?
//        }else{
//            return false;
//        }
        $db->runCommand($sqlForAuto);
        $db->runCommand($sqlForBrend);
        return $db->runCommand($sqlForOwner);
    }

    function insertToDB(){
        $db = new DB();

        //done
        $sqlForOwner = "insert into owners(last_name) values('".$this->getAutomobile()->getOwnerName()."')";
        $db->runCommand($sqlForOwner);

        $sqlForOwnerCode = 'select max(code) last_id from owners;';
        $codeOwnerArr = $db->makeQuery($sqlForOwnerCode);
        $codeOwner=$codeOwnerArr[0]['last_id'];

        //done
        $sqlForAutomobile = 'insert into automobiles(number,pass_place_count, code_owner, code_park) values('.$this->getAutomobile()->getNumber().','.$this->getAutomobile()->getPassPlaceCount().','.$codeOwner.', 3)';
        $db->runCommand($sqlForAutomobile);

        $sqlForBrendCode = 'select max(code) last_id from automobiles;';
        $codeCarArr = $db->makeQuery($sqlForBrendCode);
        $codeCar = $codeCarArr[0]['last_id'];

        //done
        $sqlForBrend = "insert into brends(code_car, auto_brend) values(".$codeCar.", '".$this->getAutomobile()->getAutoBrend()."')";

        return $db->runCommand($sqlForBrend);
    }
}


class CarRow{
    private $code;
    private $carList;
    private $automobile;
    private $brend;
    private $owner;

    function __construct( CarList $carList, Automobile $automobile, Brend $brend, Owner $owner){
        //$this->code = $code;
        $this->carList = $carList;
        $this->automobile = $automobile;
        $this->brend = $brend;
        $this->owner = $owner;
    }

    function getAutomobile(){
        return $this->automobile;
    }

    function getBrend(){
        return $this->brend;
    }

    function getOwner(){
        return $this->owner;
    }
}