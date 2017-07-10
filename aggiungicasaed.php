<?php

	$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=unimi");
	
	if(!$con){
		echo "Errore nella connessione al database".pg_last_error($con);
		exit;
	}

	$Nome = pg_escape_string($_POST['Nome']);
	$Citta = pg_escape_string($_POST['Citta']);

	$query = "INSERT INTO casaeditrice (nome, citta)
				VALUES ('".$Nome."','".$Citta."')";

	$query_res = pg_query($con, $query);

	if(!query_res) {
		echo "Errore nella query1: ".pg_last_error($con);
		exit;
	} else {
		header("Location:profilodipendente.php");
	}

?>