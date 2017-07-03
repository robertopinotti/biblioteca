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


// controllo che esista una tupla in anagrafe per l'utente in sessione
$query_empty = "SELECT mailutente FROM anagrafe WHERE mailutente = '$usr' ";

$query_empty_res = pg_query($con, $query_empty);

//se non c'e' una tupla in anagrefe per l'utente in sessione, la inserisco
if(!pg_fetch_array($query_empty_res)) {

	$query_insert = " INSERT INTO anagrafe (mailutente, datanascita, cittanascita, sesso, cittaresidenza, provinciaresidenza, statoresidenza) VALUES ('".$usr."','".$DataN."','".$CittaN."','".$Sesso."','".$CittaR."','".$ProvinciaR."','".$StatoR."') ";

	$query_insert_res = pg_query($con, $query_insert);

	if(!$query_insert_res){
		echo "Errore nella query_insert_res".pg_last_error($con);
	}

} else { // altrimenti la aggiorno

	$query_update = " UPDATE anagrafe SET
		  	mailutente = '$usr',
		  	datanascita = '$DataN',
		  	cittanascita = '$CittaN',
		  	sesso = '$Sesso',
		  	cittaresidenza = '$CittaR',
		  	provinciaresidenza = '$ProvinciaR',
		  	statoresidenza = '$StatoR'
		  	WHERE mailutente = '$usr' ";

	$query_update_res = pg_query($con, $query_update);

	if(!$query_update_res){
		echo "Errore nella query_update_res".pg_last_error($con);
	}

}

header("Location:profiloutente.php");

?>