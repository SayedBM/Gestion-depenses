<?php

$serverName = "DESKTOP-18KF3PL\SQLEXPRESS";
$database = "GestionDepenses";
$uid = "";
$pass = "";

$connection = [
"Database" => $database,
"Uid"=> $uid,
"PWD"=>$pass
];


$conn = sqlsrv_connect($serverName, $connection);

if (!$conn) 
    die(print_r(sqlsrv_errors(), true));
else
echo "c'est Bon";
//
//$tsql ="select * from depense";

//$stmt = sqlsrv_query($conn, $tsql);

//if($stmt ==false){
//    echo 'Erreur';
//}
//while ($obj =sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
 //   echo $obj['Description'].'</br>';

//}
//sqlsrv_free_stmt($stmt);
//sqlsrv_close($conn)
?>