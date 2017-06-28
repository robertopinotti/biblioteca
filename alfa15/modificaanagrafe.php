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

$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=postgres");

if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

$DataN = pg_escape_string($_POST['DataN']);
$CittaN = pg_escape_string($_POST['CittaN']);
$Sesso = pg_escape_string($_POST['Sesso']);
$CittaR = pg_escape_string($_POST['CittaR']);
$ProvinciaR = pg_escape_string($_POST['ProvinciaR']);
$StatoR = pg_escape_string($_POST['StatoR']);

$query2 = "
		  UPDATE
		  	anagrafe
		  SET
		  	mailutente = '$usr',
		  	datanascita = '$DataN',
		  	cittanascita = '$CittaN',
		  	sesso = '$Sesso',
		  	cittaresidenza = '$CittaR',
		  	provinciaresidenza = '$ProvinciaR',
		  	statoresidenza = '$StatoR'
		  WHERE mailutente = '$usr' /* ERRORE, se non c'e' tupla non trova utente */
		  ";

$query_res2 = pg_query($con, $query2);

if(!query_res2){
	echo "Errore nella Query2: ".pg_last_error($con);
	exit;
} else {

	echo "$usr, $DataN, $CittaN, $Sesso, $CittaR, $ProvinciaR, $StatoR";
	// header("Location:profiloutente.php");
}

?>