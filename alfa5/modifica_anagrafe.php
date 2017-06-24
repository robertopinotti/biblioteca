<?php

session_start();

// Lettura da variabili globali dei valori passati in post
if (!isset($_SESSION["mail"])) {
  $usr  = $_POST["user"];
  $pass = $_POST["pwd"];
} else {
  $usr=$_SESSION["mail"];
  $pass=$_SESSION["password"];
}

$con = pg_connect("host=localhost port=5432 dbname=esame2 user=postgres password=ciaone");
if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

$Mail = $usr;
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
}else header("Location:profilo_utente.php");
?>