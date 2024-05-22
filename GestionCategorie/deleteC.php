<?php

require_once '../connexion.php';

$id = (int)$_GET['id'];


$sql = "delete from CategorieDepenses where CategorieID = '$id'";


$val =sqlsrv_query($conn, $sql);

if($val){

header('location: indexC.php');

};



 ?>