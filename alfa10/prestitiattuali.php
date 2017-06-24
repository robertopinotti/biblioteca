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

$con = pg_connect("host=localhost port=5432 dbname=biblioteca  user=postgres password=ciaone");
if(!$con){
  echo "Errore nella connessione al database: ".pg_last_error($con);
  exit;
}
$query="SELECT * FROM dipendente WHERE mail='$usr' AND password='$pass'";
$query_res = pg_query($con, $query);
if(!$query_res){
  echo "Errore nella query".pg_last_error($con);
  exit();
}

if (pg_fetch_array($query_res))
{  //se ho ottenuto almeno un risultato, vuol dire che il cliente è
   //stato riconosciuto
   $_SESSION["mail"]=$usr;
   $_SESSION["password"]=$pass;
?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Prestiti Attuali | Biblioteca</title>
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
  <h2><span>Prestiti Attuali e Termina Prestito</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profilodipendente.php">Profilo Dipendente</a></li>
  <li class="active">Prestiti Attuali e Termina Prestito</li>
</ul>

  <div class="row">

  <!-- PRESTITI PASSATI -->
    
  <div class="col-md-12">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3><strong>Prestiti Attuali e Termina Prestito</strong></h3>
      </div>
      <div class="panel-body">
        
        <!-- PRESTITI PASSATI -->
        
        <?php

        $query_prestiti_passati = "SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE dataFine IS null ";

        if($query_prestiti_passati = @pg_query(" SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE dataFine IS null")){

          echo '<table class="table table-striped table-hover">';
          echo "\n\t<thead><tr>";

          echo "\n\t\t<td><b>mail utente</b></td>";
          echo "\n\t\t<td><b>titolo</b></td>";
          echo "\n\t\t<td><b>isbn</b></td>";
          echo "\n\t\t<td><b>edizione</b></td>";
          echo "\n\t\t<td><b>data inizio</b></td>";
          echo "\n\t\t<td><b>data fine</b></td>";

          echo "\n\t</thead></tr>";

          while($row = pg_fetch_assoc($query_prestiti_passati)) {
            echo "\n\t<tbody><tr>";

            echo "\n\t\t<td>{$row['mailutente']}</td>";
            echo "\n\t\t<td>{$row['titolo']}</td>";
            echo "\n\t\t<td>{$row['isbn']}</td>";
            echo "\n\t\t<td>{$row['edizione']}</td>";
            echo "\n\t\t<td>{$row['datainizio']}</td>";
            echo "\n\t\t<td><form action='URL'><button type='submit' class='btn btn-primary btn-xs'>TERMINA PRESTITO</button></form></td>";

            echo "\n\t</tbody></tr>";
          }

          echo "</table>";

        } else {

          die("Errore nella query: " . pg_last_error($conn));

        }

        ?>

      </div>
    </div>

  </div> <!-- <div class="col-md-12"> -->

  </div> <!-- <div class="row"> -->

</div> <!-- <div class="container"> -->

</body>
</html>

<?php
}
else
{   // l'utente non e' riconosciuto

    
    unset($_SESSION["mail"]);
    unset($_SESSION["password"]);
    header("Location: index.html");
}
?>