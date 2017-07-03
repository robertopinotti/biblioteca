<?php

session_start();

// Lettura da variabili globali dei valori passati in post
if (!isset($_SESSION["mail"]))
  $Mail  = $_POST["user"];
else
  $Mail=$_SESSION["mail"];

// $Mail = $_GET['Mail'];//Qui andrà messa la mail ricavata dalla session di profilo utente
$Isbn = $_GET['Isbn'];
$Edizione = $_GET['Edizione'];

$con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=postgres");

if(!$con){
	echo "Errore nella connessione al database".pg_last_error($con);
	exit;
}

?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Prenota Libro | Biblioteca</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <link href="css/bootstrap-united.css" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    
  <style type="text/css">
    body {
      padding-bottom: 50px;
    }
    img{
      width: 100%;
    }    
    h2 {
      position: absolute;
      top: 50px;
      left: 50px;

    }
    h2 span { 
      color: white; 
      background: rgba(0, 0, 0, 0.7); 
    }
    .container {
      padding-top: 10px;
    }
  </style>
  
</head>
<body>

<div class="image">
  <img src="image/biblioteca2.jpg" class="img-responsive" alt="Responsive image">  
  <h2><span>Prenota Libro</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profiloutente.php">Profilo Utente</a></li>
  <li><a href="ricercalibro.php">Ricerca Libro</a></li>
  <li class="active">Prenota Libro</li>
</ul>
    
  <div class="jumbotron">

<?php

// echo "Questo è l' isbn(".$Isbn.") e questa l'edizione (".$Edizione.") del libro richiesto.<br/><br/>";

$query = "SELECT a.NReg
		  FROM copia AS a
		  WHERE ((a.isbnlibro = '$Isbn') AND (a.edizionelibro = '$Edizione'))
		  EXCEPT
		  (SELECT p.nregcopia
		   FROM (prestito AS p JOIN copia AS c ON (p.nregcopia =c.nreg))
		   WHERE ((p.datafine IS NULL)
		   		 AND (c.isbnlibro = '$Isbn') 
		   		 AND (c.edizionelibro = '$Edizione')))";

$query_res = pg_query($con, $query);

if(!$query_res){ 
	echo "<p>Errore nella formulazione della query:</p>".pg_last_error();
}

if(! $row = pg_fetch_array($query_res)){
	echo "<p>Non ci sono copie disponibili per questo libro, <a href='ricercalibro.html'>cercane un altro</a></p>";

}else{

	$NReg = $row[0]."\n";

	$query1 = "SELECT COUNT(mailutente) 
               FROM (prestito AS pr JOIN utente AS ut ON (pr.mailutente = ut.mail))
               WHERE ( (pr.datafine IS NULL) 
                     AND (pr.mailutente = '$Mail'))
               HAVING COUNT(mailutente) < (
                            SELECT DISTINCT p.numerolibri 
                            FROM (permesso AS p JOIN utente AS u ON (p.tipoutente = u.tipo))
                            WHERE (u.mail='$Mail')
                            GROUP BY  (p.numerolibri))";

    $query_res1 = pg_query($con, $query1);

    if(!$query_res1){ 
	echo " Errore nella query ".pg_last_error();
    }

    if(!pg_fetch_array($query_res1)){
		echo "<p>Non puoi prenotare altri libri perché hai superato la soglia massima di libri in prestito contemporaneamente.</p>";
    }else{
                         
		$query2 = "INSERT INTO prestito (mailutente, nregcopia) VALUES ('".$Mail."','".$NReg."')";
		$query_res2 = pg_query($con, $query2);

		if(!$query_res2)
			echo "<p>Errore nel risultato della query:</p>".pg_last_error();
		else
			echo "<br/><br/><p>Hai prenotato la copia, ora devi aspettare che un dipendente della biblioteca convalidi la tua prenotazione!</br><br/>
		   <a href='profiloutente.php'>Torna al tuo profilo</a> oppure <a href='ricercalibro.html'>cerca un nuovo libro</a></p>";

	}

}

?>

</div> <!-- <div class="jumbotron"> -->
</div> <!-- <div class="container"> -->

</body>
</html>