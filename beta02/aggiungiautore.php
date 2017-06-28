<?php

$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=postgres");
if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

$Nome = pg_escape_string($_POST['Nome']);
$Cognome = pg_escape_string($_POST['Cognome']);
$DataN = pg_escape_string($_POST['DataN']);
$CittaN = pg_escape_string($_POST['CittaN']);
$Bio = pg_escape_string($_POST['Bio']);

$query = "INSERT INTO autore(nome, cognome, datanascita, cittanascita, biografia) VALUES ('".$Nome."','".$Cognome."','".$DataN."','".$CittaN."','".$Bio."')";
$query_res = pg_query($con, $query);

if(!query_res){
	echo "Errore nella query1: ".pg_last_error($con);
	exit;
}else header("Location:profilodipendente.php");

?>