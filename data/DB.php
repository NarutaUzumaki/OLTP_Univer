<?php

class DB{
    private $errText = "";
    /**
    * @var PDO
    */
    private $conn;

    function getErrText(){
        return $this->errText;
    }

    function connect(){
        $this->errText = "";
        try{
            $srvName = "DESKTOP-ILEFGR6";
            $dataBase = "Konyshev_309_1";
            $connOptions = [
                "Database"=>"Konyshev_309_1",
                "CharacterSet"=>"UTF-8"
            ];

            $this->conn = new PDO("sqlsrv:Server=$srvName;Database=$dataBase");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }
        catch (PDOException $e){
            $this->errText = "Smt Wrong!". $e->getMessage();
            return false;
        }
    }

    function disconnet(){
        unset($this->conn);
    }

    function makeQuery($sqlText, $flg_disconnect = true){
        $this->errText = "";
        $result = [];
        if (!isset($this->conn)){
            $this->connect();
        }
        try {
            $sql_stmt = $this->conn->query($sqlText);
        }catch (PDOException $e){
            $this->errText = $e->getMessage();
            return false;
        }
        while ($row = $sql_stmt->fetch(PDO::FETCH_ASSOC)){
            $result[] = $row;
        }
        $sql_stmt->closeCursor();
        return $result;
    }

    function runCommand($sqlText, $flg_disconnect = true){
        if (!isset($this->conn)){
            $this->connect();
        }
        try {
            $sql_stmt = $this->conn->prepare($sqlText);
            $sql_stmt->execute();
            return true;
        }catch (PDOException $e){
            $this->errText = $e->getMessage();
            return false;
        }
    }

    function runSP(string $spName, array $params = []){
        if (!isset($this->conn)){
            $this->connect();
        }
        $reslut = [];
        $str = str_repeat("?, ", count($params));
        if (strlen($str) > 0){
            $str = substr($str, 0, strlen($str) - 2);
        }
        $sqlText = "exec $spName $str";
        try {
            $sql_stmt = $this->conn->prepare($sqlText);
            foreach ($params as $key=>$param){
                if (isset($param[3])) {
                    $sql_stmt->bindParam($key+1, $param[0], $param[1], $param[2]);
                }else{
                    $sql_stmt->bindParam($key+1, $param[0], $param[1]);
                }
            }
            $sql_stmt->execute();
            try {
                do {
                    $one_result = [];
                    while ($row = $sql_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $one_result[] = $row;
                    }
                    $reslut[] = $one_result;
                }while($sql_stmt->nextRowset());
            } catch (PDOException $e){}
            $sql_stmt->closeCursor();
            foreach ($params as $key=>$param){
                if (isset($param[3])){
                    $reslut['out_params'][$key] = $param[0];
                }
            }
        }catch (PDOException $e){
            $this->errText = $e->getMessage();
            echo $this->errText;
            return false;
        }
        return $reslut;
    }
}