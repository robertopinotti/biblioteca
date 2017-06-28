<?php

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

    <title>Prestito Convalidato | Biblioteca</title>
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
  <h2><span>Prestito Convalidato</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profilodipendente.php">Profilo Dipendente</a></li>
  <li><a href="prestitidaconvalidare.php"> Prestiti Da Convalidare</a></li>
  <li class="active">Prestito Convalidato</li>
</ul>
    
  <div class="jumbotron">
  	
  <?php

  	session_start();
	  $Mail = $_GET['Mail'];
	  $NReg = $_GET['NReg'];

  	$query = "UPDATE prestito
		  		SET (datainizio) = ('now()')
		  		WHERE ((mailutente = '$Mail') AND (nregcopia = '$NReg'))";

	  $query_res = pg_query($con, $query);

	  if(!$query_res){ 
		  echo " Errore nella query ".pg_last_error();
	  }

	  echo "<p>Hai convalidato il prestito!</br><br/>
		   <a href='prestitidaconvalidare.php'>Torna ai prestiti in attesa di convalida</a></p>";

  ?>

</div> <!-- <div class="jumbotron"> -->
</div> <!-- <div class="container"> -->

</body>
</html>