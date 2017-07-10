<?php

	$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=unimi");

	if(!$con){
		echo "Errore nella connessione al database".pg_last_error($con);
		exit;
	}

	$Titolo = pg_escape_string($_POST['Titolo']);
	$CasaEd = pg_escape_string($_POST['CasaEd']);
	$Edizione = pg_escape_string($_POST['Edizione']);
	$Isbn = pg_escape_string($_POST['Isbn']);
	$DataP = pg_escape_string($_POST['DataP']);
	$Lingua = pg_escape_string($_POST['lingua']);
	$Autore = pg_escape_string($_POST['Autore']);
	$Autore1 = pg_escape_string($_POST['Autore1']);
	$Autore2 = pg_escape_string($_POST['Autore2']);
	$Autore3 = pg_escape_string($_POST['Autore3']);
	$Autore4 = pg_escape_string($_POST['Autore4']);
	$NCopie = pg_escape_string($_POST['NCopie']);
	$Sez = pg_escape_string($_POST['Sez']);
	$Scaf = pg_escape_string($_POST['Scaf']);

	$query1 = "INSERT INTO Libro (titolo, edizione, isbn, nomecasaeditrice, datapubblicazione, lingua)
				VALUES ('".$Titolo."','".$Edizione."','".$Isbn."','".$CasaEd."','".$DataP."','".$Lingua."')";
	$query_res1 = pg_query($con, $query1);

	$queryA = "INSERT INTO scrive (isbnlibro, edizionelibro, codautore)
				VALUES ('".$Isbn."','".$Edizione."','".$Autore."')";
	$query_resA = pg_query($con, $queryA);

	$queryA1 = "INSERT INTO scrive (isbnlibro, edizionelibro, codautore)
				VALUES ('".$Isbn."','".$Edizione."','".$Autore1."')";
	$query_resA1 = pg_query($con, $queryA1);

	$queryA2 = "INSERT INTO scrive (isbnlibro, edizionelibro, codautore)
				VALUES ('".$Isbn."','".$Edizione."','".$Autore2."')";
	$query_resA2 = pg_query($con, $queryA2);

	$queryA3 = "INSERT INTO scrive (isbnlibro, edizionelibro, codautore)
				VALUES ('".$Isbn."','".$Edizione."','".$Autore3."')";
	$query_resA3 = pg_query($con, $queryA3);

	$queryA4 = "INSERT INTO scrive (isbnlibro, edizionelibro, codautore)
				VALUES ('".$Isbn."','".$Edizione."','".$Autore4."')";
	$query_resA4 = pg_query($con, $queryA4);

		
	while ($NCopie > 0) {
		$queryB = "INSERT INTO copia (sezione, scaffale, edizionelibro, isbnlibro, datareg)
					VALUES ('".$Sez."','".$Scaf."','".$Edizione."','".$Isbn."',CURRENT_DATE)";
		$query_resB = pg_query($con, $queryB);
		$NCopie--;
		echo "Copia inserita correttamente.";
	}

	if(!query_res1) {
		echo "Errore nella Query1: ".pg_last_error($con);
		exit;
	} else {
		header("Location:profilodipendente.php");
	}

?>