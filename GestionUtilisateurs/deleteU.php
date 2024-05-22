<?php

require_once '../connexion.php';

$id = (int)$_GET['id'];


$sql = "delete from utilisateur where UtilisateurID = '$id'";


$val =sqlsrv_query($conn, $sql);

if($val){

header('location: indexU.php');

};



 ?>