<?php

$dsn="mysql:host=localhost;dbname=icrvhg7o0e";
$dbusername = "-----";
$dbpassword = "-----";

try{
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    echo "Could not connect: " . $e->getMessage();
}

?>