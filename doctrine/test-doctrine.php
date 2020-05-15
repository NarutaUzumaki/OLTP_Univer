<?php
require_once __DIR__."/doctrine-bootstrap.php";

try{
    $entityManager->getConnection()->connect();
    echo 'connection success';
}catch (Exception $e){
    echo 'connection failure';
}

//$code = $_GET['code'];
//$spec = $entityManager->find('Brend', $code);
//if ($spec === null){
//    echo "no automobile find.\n";
//    exit(1);
//}
//var_dump($spec);

//сделать все в лабе, src нужная папка
//data не нужна
//к интерфейсу прикручивать не надо

//Insert
////------------------------------------------------------
//$newBrend = new Brend();
//$newBrend->setAutoBrend("Doctrine");
//$newBrend->setCodeCar(20);
//var_dump($newBrend);
//
//$entityManager->persist($newBrend);
//$entityManager->flush();
//var_dump($newBrend);

//Modify data
////--------------------------------------------------------
//$brend = $entityManager->getRepository('Brend')->findOneBy(['auto_brend'=>"Doctrine"]);
//$brend->setAutoBrend('Доктрін');
//$entityManager->flush();
//
//$brend2 = $entityManager->getRepository('Brend')->findOneBy(['auto_brend'=>"Доктрін"]);
//var_dump($brend2);

//Delete
//----------------------------------------------------------
//$brend = $entityManager->getRepository('Brend')->findOneBy(['auto_brend'=>"Доктрін"]);
//$entityManager->remove($brend);
//$entityManager->flush();
//
//$brend2 = $entityManager->getRepository('Brend')->findOneBy(['auto_brend'=>"Доктрін"]);
//var_dump($brend2);

//Native reading
//----------------------------------------------------------
//$rsm = new \Doctrine\ORM\Query\ResultSetMapping();
//$rsm -> addEntityResult('Brend','s');
//$rsm -> addFieldResult('s', 'code', 'code');
//$rsm ->addFieldResult('s', 'code_car', 'code_car');
//$rsm ->addFieldResult('s', 'auto_brend', 'auto_brend');
//
//$sql = "select code, code_car, auto_brend from brends ";
//
//$query = $entityManager->createNativeQuery($sql, $rsm);
//
//$brend = $query->getResult();
//var_dump($brend);

//DQL
//--------------------------------------------------------------
//$dql_query = $entityManager->createQuery(
//    "Select code, code_car, auto_brend from brends
//            where auto_brend LIKE '%Lexus%'"
//);
//$brend = $dql_query->getResult();
//
//if ($brend == null){
//    echo "Brend does not exist";
//    exit(1);
//}
//var_dump($brend);

//Procedure
//----------------------------------------------------------------
$code = 6;
$conn = $entityManager->getConnection()->getWrappedConnection();
try{
    $sqlText = "exec getReadingDataRow :code";
    $sql_stmt = $conn->prepare($sqlText);
    $sql_stmt->bindParam(':code', $code, \PDO::PARAM_INT);
    $sql_stmt->execute();
    do{
        $one_result = [];
        while($row = $sql_stmt->fetch(PDO::FETCH_ASSOC)){
            $one_result[] = $row;
        }
        $result[] = $one_result;
    }while ($sql_stmt->nextRowset());
    $sql_stmt->closeCursor();
    var_dump($result);
}catch (Exception $e){

}