<?php
session_start();
// Lettura da variabili globali dei valori passati in post
if (!isset($_SESSION["mail"]))
{  $usr  = $_POST["user"];
   $pass = $_POST["pwd"];
}
else
{
  $usr=$_SESSION["mail"];
  $pass=$_SESSION["password"];
}

$con = pg_connect("host=localhost port=5432 dbname=biblioteca  user=postgres password=unimi");
if(!$con){
  echo "Errore nella connessione al database: ".pg_last_error($con);
  exit;
}

?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Prestiti Scaduti | Biblioteca</title>
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
    @media (max-width:768px){
        h2 {
            top: -10px;
            left: 10px;
            font-size: 190%;
        }
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
  <h2><span>Prestiti Scaduti</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profilodipendente.php">Profilo Dipendente</a></li>
  <li class="active">Prestiti Scaduti</li>
</ul>

  <div class="row">
  <div class="col-md-12">
    
    <div class="panel panel-default">

      <div class="panel-heading">
        <h3><strong>Prestiti Scaduti</strong></h3>
      </div>

      <div class="panel-body">
        
        <?php

        $query="SELECT pre.datainizio+per.tempoprestito AS datafineteorica, ute.mail, lib.titolo, lib.isbn, lib.edizione, cop.nreg, pre.datainizio
                FROM
                (((( permesso AS per JOIN utente AS ute ON per.tipoutente=ute.tipo)
                                JOIN prestito AS pre ON (pre.mailutente=ute.mail)
                                JOIN copia AS cop ON (pre.nregcopia=cop.nreg))
                                JOIN libro AS lib ON ((cop.isbnlibro=lib.isbn)AND(cop.edizionelibro=lib.edizione ))))
                WHERE (((pre.datainizio + per.tempoprestito) < 'now()') AND (pre.datafine IS NULL))";

        $query_res = pg_query($con, $query);

        if($query_res){

          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr>";
          echo "<td><b>mail utente</b></td>";
          echo "<td><b>titolo</b></td>";
          echo "<td><b>isbn</b></td>";
          echo "<td><b>edizione</b></td>";
          echo "<td><b>nreg</b></td>";
          echo "<td><b>data inizio</b></td>";
          echo "<td><b>data fine teorica</b></td>";
          echo "<td><b>termina prestito</b></td>";
          echo "</thead></tr>";

          while($row = pg_fetch_assoc($query_res)) {

            $Mail = $row['mail'];
            $NReg = $row['nreg'];

            echo "<tbody><tr>";
            echo "<td>{$row['mail']}</td>";
            echo "<td>{$row['titolo']}</td>";
            echo "<td>{$row['isbn']}</td>";
            echo "<td>{$row['edizione']}</td>";
            echo "<td>{$row['nreg']}</td>";
            echo "<td>{$row['datainizio']}</td>";
            echo "<td>{$row['datafineteorica']}</td>";
            echo "<td><a href='terminaprestito.php?Mail=".$Mail."&NReg=".$NReg."'>TERMINA PRESTITO</a></td>";
            echo "</tbody></tr>";

          }

          echo "</table>";
          echo "</div>";

        } else {

          die("Errore nella query: " . pg_last_error($con));

        }

        ?>

      </div> <!-- <div class="panel-body"> -->

    </div> <!-- <div class="panel panel-default"> -->

</div> <!-- <div class="col-md-12"> -->
</div> <!-- <div class="row"> -->
</div> <!-- <div class="container"> -->

</body>
</html>