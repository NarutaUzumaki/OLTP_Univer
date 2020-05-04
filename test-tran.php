<?php
$srvName = 'DESKTOP-ILEFGR6';
$connOptions = ["Database"=>"Konyshev_309_1", "CharacterSet"=>"UTF-8"];
$conn = sqlsrv_connect($srvName, $connOptions);

showMeData('before transaction: ', $conn);
if (!sqlsrv_begin_transaction($conn)){
    echo "Cannot begin transaction";
    exit;
}

$sql = "update automobiles set pass_place_count = 19 where code = ?";
$stmt1 = sqlsrv_query($conn,$sql,[6]);
$sql = "update automobiles set pass_place_count = ? where code = ?";
$stmt2 = sqlsrv_query($conn,$sql,[21,7]);

if ($stmt1 && $stmt2){
    sqlsrv_commit($conn);
    echo "transaction successful </br>";
}else{
    sqlsrv_rollback($conn);
    echo "transaction die </br>";
}
showMeData('after transaction: ', $conn);

//sqlsrv_commit($conn);
//
//sqlsrv_free_stmt($stmt);
//sqlsrv_commit($conn);


function showMeData($message, $conn){
    $sql = "select code, number, pass_place_count, code_owner, code_park from automobiles where code in(?,?)";
    $params = [6,7];
    $stmt = sqlsrv_query($conn, $sql, $params);
    $result = [];
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $result[] = $row;
    }
    echo $message . "</br>";
    echo "<pre>";
    var_dump($result);
    echo "</pre>";
}