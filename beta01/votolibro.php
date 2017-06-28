<?php

session_start();

// Lettura da variabili globali dei valori passati in post
if (!isset($_SESSION["mail"]))
  $usr  = $_POST["user"];
else
  $usr=$_SESSION["mail"];

$con = pg_connect('host=localhost port=5432 dbname=biblioteca user=postgres password=postgres');

if(!$con){
	echo 'Errore nella connessione al database'.pg_last_error($con);
	exit;
}

$Voto = pg_escape_string($_POST['Voto']);
$Commento = pg_escape_string($_POST['Commento']);
$NReg = $_GET['NReg'];

?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Valutazione Registrata | Biblioteca</title>
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
  <h2><span>Valutazione Registrata</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profiloutente.php">Profilo Utente</a></li>
  <li class="active">Valutazione Registrata</li>
</ul>
    
  <div class="jumbotron">
  	
  <?php

  	$query1 = " UPDATE prestito
		            SET voto = '$Voto', commento = '$Commento'
		            WHERE mailutente = '$usr' AND nregcopia = '$NReg' ";

	$query_res1 = pg_query($con, $query1);

	if(!$query_res1){ 
		echo " Errore nella query ".pg_last_error();
	}

	echo "<p>La tua valutazione è stata registrata. <a href='profiloutente.php'>Torna al profilo</a></p>";

   ?>

</div> <!-- <div class="jumbotron"> -->
</div> <!-- <div class="container"> -->

</body>
</html>