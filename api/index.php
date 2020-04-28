<?php
include __DIR__ . '/../data/autorun.php';
//include __DIR__ . '/../general/common-func.php';

if ($_GET['action'] == 'getAuto'){
    $carList = new CarList((int)$_GET['park_code']);
    $carList->readFromDB();
    $data = ['auto'=>$carList];
    //var_dump("success");
}elseif ($_GET['action'] == 'getAutoRow'){
    $carList = new CarList((int)$_GET['auto_row_code']);
    $carList->readRowFromDB();
    $data = ['autoRow'=>$carList];
}elseif ($_GET['action'] == 'updAutoRow'){
    $carList = new CarList((int)$_POST['auto_row_code']);
    $carList->readRowFromDB();
    $carList->setPassPlaces((int)$_POST['pass_places_count']);
    $carList->setOwnerName($_POST['owner_name']);
    $carList->setCodeOwner((int)$_POST['code_owner']);
    $carList->setAutoBrend($_POST['auto_brend']);
    $carList->setCodeBrend((int)$_POST['code_brend']);
    $data = ['updated' => $carList->writeToDB()];
}elseif ($_GET['action'] == 'remAutoRow'){
    $carList = new CarList((int)$_POST['auto_row_code']);
    $data = ['deleted' => $carList->remFromDB()];
}elseif ($_GET['action'] == 'insAutoRow'){
    $carList = new CarList(0);
    //                                                    1                        2                      3                                4                            5                         6                            7                        8                           9
    $carList->setAutomobile(new Automobile((int)$_POST['auto_row_code'],(int)$_POST['number'],(int)$_POST['pass_places_count'],(int)$_POST['code_owner'],(string)$_POST['owner_name'],(int)$_POST['code_brend'],(string)$_POST['auto_brend'],(int)$_POST['code_park'],(string)$_POST['park_name']));
    $data = ['inserted' => $carList->insertToDB()];
}else{
    $data = ['error' => 'bad request'];
}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Accept-Language: *');

echo json_encode($data);