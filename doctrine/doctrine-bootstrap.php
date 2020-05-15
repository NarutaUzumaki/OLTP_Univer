<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
require_once __DIR__."/../vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

$conn = array(
    "driver" => "pdo_sqlsrv",
    "dbname" => "Konyshev_309_1"
);
$entityManager = EntityManager::create($conn, $config);