<?php


class DB{
    private $errText = "";
    private $conn;

    function getErrText(){
        return $this->errText;
    }

    function connect(){
        $this->errText = "";
        try{
            $srvName = "DESKTOP-ILEFGR6";
            $connOptions = [
                "Database"=>"Konyshev_309_1",
                "CharacterSet"=>"UTF-8"
            ];

            $this->conn = sqlsrv_connect($srvName,$connOptions);
            if($this->conn == false){
                $this->errText = "Лох";
                return false;
            }
            return true;
        }
        catch (Exception $e){
            $this->errText = "Smt Wrong!";
            return false;
        }
    }

    function disconnet(){
        sqlsrv_close($this->conn);
    }

    function makeQuery($sqlText, $flg_disconnect = true){
        $this->errText = "";
        $result = [];
        try {
            if($this->conn || $this->connect()){
                $sql_stmt = sqlsrv_query($this->conn,$sqlText);
                if (!$sql_stmt){
                    $this->errText = "sql_stmt лох";
                    return false;
                }
                while($row = sqlsrv_fetch_array($sql_stmt,SQLSRV_FETCH_ASSOC)){
                    $result[] = $row;
                }
                sqlsrv_free_stmt($sql_stmt);
                return $result;
            }
        }
        catch (Exception $e){
            $this->errText = "Smth wrong with db!";
            return false;
        }
    }

    function runCommand($sqlText, $flg_disconnect = true){
        try {
            if ($this->conn || $this->connect()){
                $sql_stmt = sqlsrv_query($this->conn, $sqlText);
                if (!$sql_stmt){
                    return false;
                }
                sqlsrv_free_stmt($sql_stmt);
                return true;
            }
        }
        catch (Exception $e){
            $this->errText = "Smth wrong with db!";
            return false;
        }
    }

    function runSP(string $spName, array $params = []){
        try {
            if ($this->conn || $this->connect()) {
                $reslut = [];

                $str = str_repeat("?, ", count($params));
                if (strlen($str) > 0) {
                    $str = substr($str, 0, strlen($str) - 2);
                }
                $sqlText = "exec $spName $str";

                foreach ($params as $key => $param) {
                    if (isset($param[1]) && $param[1] == 'out') {
                        $params[$key][1] = SQLSRV_PARAM_OUT;
                    } else {
                        $params[$key][1] = SQLSRV_PARAM_IN;
                    }
                }
                $sql_stmt = sqlsrv_prepare($this->conn, $sqlText, $params);
                sqlsrv_execute($sql_stmt);
                while ($row = sqlsrv_fetch_array($sql_stmt, SQLSRV_FETCH_ASSOC)) {
                    $one_result[] = $row;
                }
                $reslut[] = $one_result;

                while (sqlsrv_next_result($sql_stmt)){
                    $one_result = [];
                    while ($row = sqlsrv_fetch_array($sql_stmt, SQLSRV_FETCH_ASSOC)){
                        $one_result[] = $row;
                    }
                    $reslut[] = $one_result;
                }
                return $reslut;
            }
        }
        catch (Exception $e){
            $this->errText = "Error in SP method";
            return false;
        }
    }
}