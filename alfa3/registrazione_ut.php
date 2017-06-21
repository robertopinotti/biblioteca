<?php

$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=Giallonero96");
if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}
$email =pg_escape_string($_POST['email']);
$password =pg_escape_string($_POST['pwd']);
$nome =pg_escape_string($_POST['nome']);
$cognome =pg_escape_string($_POST['cognome']);
$tel =pg_escape_string($_POST['telefono']);
$tipo =pg_escape_string($_POST['tipo']);
$query="SELECT email FROM utente WHERE email=$email ";
$query_res=pg_query($con, $query);
if(!$query_res){
	$query1="INSERT INTO utente (email, password, nome, cognome, telefono, data_registrazione, tipo) VALUES ('".$email."','".$password."', '".$nome."','".$cognome."',
		'".$tel."','now()', '".$tipo."') ";
	$query_res1=pg_query($con, $query1);
	if(!$query_res1){
		echo "Errore nella query2: ".pg_last_error($con);
		exit;
	}
	else header("Location:login.php");
}

else{ echo "errore nella query1: ".pg_last_error($con);

}

?>
