<?php
$srvName = 'DESKTOP-ILEFGR6';
$connOptions = ["Database"=>"Konyshev_309_1", "CharacterSet"=>"UTF-8"];
$conn = sqlsrv_connect($srvName, $connOptions);

$data['transaction'] = $_GET['tran_number'];

function showMeData($message, $conn){
    global $data;
    $sql = "select code, code_car, auto_brend from brends where code_car in(?,?)";
    $params = [8,10];
    $result = [];
    if ($stmt = sqlsrv_query($conn,$sql,$params)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $row;
        }
    }else{
        $result['err'] = sqlsrv_errors();
    }
//    echo $message . "</br>";
//    echo "<pre>";
//    var_dump($result);
//    echo "</pre>";
    $data[$message] = $result;
}

showMeData('1. before transaction: ', $conn);
if (!sqlsrv_begin_transaction($conn)){
    $data['err'] = 'Cannot begin transaction';
}else{
    if ($_GET['tran_number'] == 1){
        $sql = "update brends set auto_brend = 'Pagani' where code_car = 8";
    }else{
        $sql = "update brends set auto_brend = 'Mazda' where code_car = 10";
    }
    $stmt = sqlsrv_query($conn,$sql);
    if (!$stmt){
        $data['upd err'] = sqlsrv_errors();
    }
    //sleep(3);
    showMeData('2. inside transaction: ', $conn);
}
sqlsrv_commit($conn);
showMeData('3. after transaction', $conn);

if ($stmt) sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
header('Accept-LAnguage: *');

echo json_encode($data);