<?php
//    try{
//        $srvName = "DESKTOP-ILEFGR6";
//        $connOptions = [
//            "Database"=>"Konyshev_309_1",
//            "CharacterSet"=>"UTF-8"
//        ];
//        $conn = sqlsrv_connect($srvName, $connOptions);
//        if($conn == false) {
//            die("Лох");
//        }
//    }
//    catch (Exception $e){
//        echo ("Smth wrong!");
//    }
//    echo "Success!";
    require 'data/autorun.php';
    $carList = new CarList(4);
    $arr = $carList->readFromDB();
    //var_dump($carList->readFromDB());
    ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Auto parking</title>
</head>
<body>
<table border="1">
    <thead>
    <tr>
        <th>Номер машины</th>
        <th>Кол-во мест</th>
        <th>Марка</th>
        <th>Имя владельца</th>
    </tr>
    <?php //echo '<br/>'; var_dump($arr);
    foreach ($arr as $CarResult): ?>
    <tr>
        <?php //var_dump($CarResult); ?>
        <td><?php echo $CarResult->getNumber() ?></td>
        <td><?php echo $CarResult->getPassPlaceCount() ?></td>
        <td><?php echo $CarResult->getAutoBrend() ?></td>
        <td><?php echo $CarResult->getOwnerName() ?></td>
    </tr>
    <?php endforeach; ?>
    </thead>
</table>


</body>
</html>
