<?php

$con = pg_connect("host=localhost port=5432 dbname=Esercizio1 user=postgres password=postgres");
if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

$Mail = pg_escape_string($_POST['Mail']);
$DataN = pg_escape_string($_POST['DataN']);
$CittàN = pg_escape_string($_POST['CittàN']);
$Sesso = pg_escape_string($_POST['Sesso']);
$CittàR = pg_escape_string($_POST['CittàR']);
$ProvR = pg_escape_string($_POST['ProvinciaR']);
$StatoR = pg_escape_string($_POST['StatoR']);

$query2 = "INSERT INTO Anagrafe (mailutente, datanascita, cittànascita, sesso, cittàresidenza, provinciaresidenza, statoresidenza) VALUES ('".$Mail."','".$DataN."','".$CittàN."','".$Sesso."','".$CittàR."','".$ProvR."','".$StatoR."')";
$query_res2 = pg_query($con, $query2);

if(!query_res2){
	echo "Errore nella Query2: ".pg_last_error($con);
	exit;
}else header("Location:login.php");
?>