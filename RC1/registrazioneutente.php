<?php

$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=postgres");
if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

$Mail = pg_escape_string($_POST['Mail']);
$Pass = pg_escape_string($_POST['Pass']);
$Tipologia = pg_escape_string($_POST['Tipologia']);
$Nome = pg_escape_string($_POST['Nome']);
$Cognome = pg_escape_string($_POST['Cognome']);
$NTel = pg_escape_string($_POST['NTel']);
$query = "SELECT mail FROM Utente WHERE mail=$Mail ";
$query_res = pg_query($con,$query);

$DataN = pg_escape_string($_POST['DataN']);
$CittaN = pg_escape_string($_POST['CittaN']);
$Sesso = pg_escape_string($_POST['Sesso']);
$CittaR = pg_escape_string($_POST['CittaR']);
$ProvR = pg_escape_string($_POST['ProvinciaR']);
$StatoR = pg_escape_string($_POST['StatoR']);
 
if(!$query_res){
	$query1 = "INSERT INTO Utente (mail, tipo, dataregistrazione, password, nome, cognome, numerotelefono) VALUES ('".$Mail."','".$Tipologia."',CURRENT_DATE ,'".$Pass."','".$Nome."','".$Cognome."','".$NTel."')";
	$query_res1 = pg_query($con, $query1);

	$query2 = "INSERT INTO Anagrafe (mailutente, datanascita, cittanascita, sesso, cittaresidenza, provinciaresidenza, statoresidenza) VALUES ('".$Mail."','".$DataN."','".$CittaN."','".$Sesso."','".$CittaR."','".$ProvR."','".$StatoR."')";
	$query_res2 = pg_query($con, $query2);

	if(!query_res1){
			echo "Errore nella Query1: ".pg_last_error($con);
			exit;
		}else{ if(!query_res2){
				 echo "Errore nella Query2: ".pg_last_error($con);
			     exit;
			 }else header("Location:index.html");
		}
}else{
	echo "Questa mail è gia' usata da un altro utente. Inseriscine un'altra".pg_last_error($con);
}

?>