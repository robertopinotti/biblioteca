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

// connessione al database
$con = pg_connect("host=localhost port=5432 dbname=biblioteca  user=postgres password=ciaone");

// se la connessione è andata male
if(!$con) {
  echo "Errore nella connessione al database: ".pg_last_error($con);
  exit;
}

$query="SELECT * FROM utente WHERE mail='$usr' AND password='$pass'";

$query_res = pg_query($con, $query);

// se la query ha qualche errore
if(!$query_res){
  echo "Errore nella query".pg_last_error($con);
  exit();
}

if (pg_fetch_array($query_res)) {
  // se ho ottenuto almeno un risultato, vuol dire che il cliente è stato riconosciuto
  $_SESSION["mail"]=$usr;
  $_SESSION["password"]=$pass;
?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Utente | Biblioteca</title>
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
  <h2><span>Ciao, <?php echo $usr ?></span></h2>
</div>

<div class="container">

  <div class="row">

  <!-- DATI UTENTE -->
    
  <div class="col-md-12">
    
    <div class="panel panel-default">

      <div class="panel-heading">

        <div class="row">
          <div class="col-md-10">
            <h3><strong>Dati Utente</strong></h3>
          </div>
          <div class="col-md-2">
            <form action="logout.php"> <button type="submit" class="btn btn-primary btn-block">LOGOUT</button> </form>
          </div>
        </div> <!-- <div class="row"> -->

      </div>

      <div class="panel-body">

        <!-- Credenziali e nominativo -->
        
        <?php

        $query_dati_utente = " SELECT * FROM utente WHERE mail='$usr' ";

        if($query_dati_utente = @pg_query(" SELECT * FROM utente WHERE mail='$usr' ")){

          echo '<table class="table table-striped table-hover">';
          echo "\n\t<thead><tr>";
          echo "\n\t\t<td><b>mail</b></td>";
          echo "\n\t\t<td><b>numero tessera</b></td>";
          echo "\n\t\t<td><b>data registrazione</b></td>";
          echo "\n\t\t<td><b>nome</b></td>";
          echo "\n\t\t<td><b>cognome</b></td>";
          echo "\n\t\t<td><b>mumero telefono</b></td>";
          echo "\n\t</thead></tr>";

          while($row = pg_fetch_assoc($query_dati_utente)) {
            echo "\n\t<tbody><tr>";
            echo "\n\t\t<td>{$row['mail']}</td>";
            echo "\n\t\t<td>{$row['numerotessera']}</td>";
            echo "\n\t\t<td>{$row['dataregistrazione']}</td>";
            echo "\n\t\t<td>{$row['nome']}</td>";
            echo "\n\t\t<td>{$row['cognome']}</td>";
            echo "\n\t\t<td>{$row['numerotelefono']}</td>";
            echo "\n\t</tbody></tr>";
          }

          echo "</table>";

        } else {

          die("Errore nella query: " . pg_last_error($conn));

        }

        ?>

        <!-- Anagrafica -->
        
        <?php

        $query_anagrafe_utente = " SELECT * FROM anagrafe WHERE mailUtente='$usr' ";

        if($query_anagrafe_utente = @pg_query(" SELECT * FROM anagrafe WHERE mailUtente='$usr' ")){

          echo '<table class="table table-striped table-hover">';
          echo "\n\t<thead><tr>";
          echo "\n\t\t<td><b>data nascita</b></td>";
          echo "\n\t\t<td><b>citta' nascita</b></td>";
          echo "\n\t\t<td><b>sesso</b></td>";
          echo "\n\t\t<td><b>citta' residenza</b></td>";
          echo "\n\t\t<td><b>provincia residenza</b></td>";
          echo "\n\t\t<td><b>stato residenza</b></td>";
          echo "\n\t</thead></tr>";

          while($row = pg_fetch_assoc($query_anagrafe_utente)) {
            echo "\n\t<tbody><tr>";
            echo "\n\t\t<td>{$row['datanascita']}</td>";
            echo "\n\t\t<td>{$row['cittanascita']}</td>";
            echo "\n\t\t<td>{$row['sesso']}</td>";
            echo "\n\t\t<td>{$row['cittaresidenza']}</td>";
            echo "\n\t\t<td>{$row['provinciaresidenza']}</td>";
            echo "\n\t\t<td>{$row['statoresidenza']}</td>";
            echo "\n\t</tbody></tr>";
          }

          echo "</table>";

        } else {

          die("Errore nella query: " . pg_last_error($conn));

        }

        ?>

        <a href="modificaanagrafe.html">Aggiungi/Modifica dati anagrafici</a>

      </div>
    </div>

  </div> <!-- <div class="col-md-12"> -->

  </div> <!-- <div class="row"> -->

  <div class="row">

  <!-- PRESTITI ATTUALI -->

  <div class="col-md-12">
    
    <div class="panel panel-default">
      <div class="panel-heading">

        <div class="row">
          <div class="col-md-10">
            <h3><strong>Prestiti Attuali</strong></h3>
          </div>
          <div class="col-md-2">
            <form action="ricercalibro.html"> <button type="submit" class="btn btn-primary btn-block">PRENOTA LIBRO</button> </form>
          </div>
        </div> <!-- <div class="row"> -->

      </div> <!-- <div class="panel-heading"> -->

      <div class="panel-body">

        <!--
        <form action="URL"><button type="submit" class="btn btn-primary btn-block">PRENOTA LIBRO</button></form>
        -->

        <!-- PRESTITI ATTUALI -->
        
        <?php

        $query_prestiti_attuali = "SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS null ";

        if($query_prestiti_attuali = @pg_query(" SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS null ")){

          echo '<table class="table table-striped table-hover">';
          echo "\n\t<thead><tr>";

          echo "\n\t\t<td><b>titolo</b></td>";
          echo "\n\t\t<td><b>isbn</b></td>";
          echo "\n\t\t<td><b>edizione</b></td>";
          echo "\n\t\t<td><b>data inizio</b></td>";
          echo "\n\t\t<td><b>scandenza prestito</b></td>";

          echo "\n\t</thead></tr>";

          while($row = pg_fetch_assoc($query_prestiti_attuali)) {
            echo "\n\t<tbody><tr>";

            echo "\n\t\t<td>{$row['titolo']}</td>";
            echo "\n\t\t<td>{$row['isbn']}</td>";
            echo "\n\t\t<td>{$row['edizione']}</td>";
            if($row['datainizio']=="")
              echo "\n\t\t<td>In attesa di convalida</td>";
            else
              echo "\n\t\t<td>{$row['datainizio']}</td>";
            echo "\n\t\t<td>{$row['datafine']}</td>";

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

  <div class="row">

  <!-- PRESTITI PASSATI -->
    
  <div class="col-md-12">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3><strong>Prestiti Passati</strong></h3>
      </div>
      <div class="panel-body">
        
        <!-- PRESTITI PASSATI -->
        
        <?php

        $query_prestiti_passati = "SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS NOT null ";

        if($query_prestiti_passati = @pg_query(" SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS NOT null")){

          echo '<table class="table table-striped table-hover">';
          echo "\n\t<thead><tr>";

          echo "\n\t\t<td><b>titolo</b></td>";
          echo "\n\t\t<td><b>isbn</b></td>";
          echo "\n\t\t<td><b>edizione</b></td>";
          echo "\n\t\t<td><b>data inizio</b></td>";
          echo "\n\t\t<td><b>data fine</b></td>";

          echo "\n\t</thead></tr>";

          while($row = pg_fetch_assoc($query_prestiti_passati)) {
            echo "\n\t<tbody><tr>";

            echo "\n\t\t<td>{$row['titolo']}</td>";
            echo "\n\t\t<td>{$row['isbn']}</td>";
            echo "\n\t\t<td>{$row['edizione']}</td>";
            echo "\n\t\t<td>{$row['datainizio']}</td>";
            echo "\n\t\t<td>{$row['datafine']}</td>";

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