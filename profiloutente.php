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
$con = pg_connect("host=localhost port=5432 dbname=biblioteca  user=postgres password=unimi");

// se la connessione è andata male
if(!$con){
  echo "Errore nella connessione al database: ".pg_last_error($con);
  exit;
}

$query="SELECT * FROM utente WHERE mail='$usr' AND password='$pass'";
$query_res = pg_query($con, $query);

if(!$query_res){
  echo "Errore nella query".pg_last_error($con);
  exit();
}

// se ho ottenuto almeno un risultato, vuol dire che il cliente è stato riconosciuto
if (pg_fetch_array($query_res)) {
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

        $query_datiutente = " SELECT * FROM utente WHERE mail='$usr' ";

        $query_datiutente_res = pg_query($con, $query_datiutente);

        if($query_datiutente_res){

          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr>";
          echo "<td><b>mail</b></td>";
          echo "<td><b>numero tessera</b></td>";
          echo "<td><b>data registrazione</b></td>";
          echo "<td><b>nome</b></td>";
          echo "<td><b>cognome</b></td>";
          echo "<td><b>mumero telefono</b></td>";
          echo "</thead></tr>";

          while($row = pg_fetch_assoc($query_datiutente_res)) {
            echo "<tbody><tr>";
            echo "<td>{$row['mail']}</td>";
            echo "<td>{$row['numerotessera']}</td>";
            echo "<td>{$row['dataregistrazione']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['cognome']}</td>";
            echo "<td>{$row['numerotelefono']}</td>";
            echo "</tbody></tr>";
          }

          echo "</table>";
          echo "</div>";

        } else {

          die("Errore nella query: " . pg_last_error($con));

        }

        ?>

        <!-- Anagrafica -->
        
        <?php

        $query_anagrafe = " SELECT * FROM anagrafe WHERE mailUtente='$usr' ";

        $query_anagrafe_res = pg_query($con, $query_anagrafe);

        if($query_anagrafe_res){

          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr>";
          echo "<td><b>data nascita</b></td>";
          echo "<td><b>citta' nascita</b></td>";
          echo "<td><b>sesso</b></td>";
          echo "<td><b>indirizzo</b></td>";
          echo "<td><b>citta' residenza</b></td>";
          echo "<td><b>provincia residenza</b></td>";
          echo "<td><b>stato residenza</b></td>";
          echo "</thead></tr>";

          while($row = pg_fetch_assoc($query_anagrafe_res)) {
            echo "<tbody><tr>";
            echo "<td>{$row['datanascita']}</td>";
            echo "<td>{$row['cittanascita']}</td>";
            echo "<td>{$row['sesso']}</td>";
            echo "<td>{$row['viaresidenza']}</td>";
            echo "<td>{$row['cittaresidenza']}</td>";
            echo "<td>{$row['provinciaresidenza']}</td>";
            echo "<td>{$row['statoresidenza']}</td>";
            echo "</tbody></tr>";
          }

          echo "</table>";
          echo "</div>";

        } else {

          die("Errore nella query: " . pg_last_error($con));

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

        <!-- PRESTITI ATTUALI -->
        
        <?php

        $query_prestitiattuali = "SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS null ";

        $query_prestitiattuali_res = pg_query($con, $query_prestitiattuali);

          if($query_prestitiattuali_res){

            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover'>";
            echo "<thead><tr>";
            echo "<td><b>titolo</b></td>";
            echo "<td><b>isbn</b></td>";
            echo "<td><b>edizione</b></td>";
            echo "<td><b>data inizio</b></td>";
            echo "<td><b>scandenza prestito</b></td>";

            echo "</thead></tr>";

            while($row = pg_fetch_assoc($query_prestitiattuali_res)) {
              echo "<tbody><tr>";

              echo "<td>{$row['titolo']}</td>";
              echo "<td>{$row['isbn']}</td>";
              echo "<td>{$row['edizione']}</td>";
              if($row['datainizio']=="")
                echo "<td>In attesa di convalida</td>";
              else
                echo "<td>{$row['datainizio']}</td>";
              echo "<td>{$row['datafine']}</td>";

              echo "</tbody></tr>";
            }

            echo "</table>";
            echo "</div>";

          } else {

            die("Errore nella query: " . pg_last_error($con));

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

        $query_prestitipassati = "SELECT * FROM prestito p JOIN copia c ON p.nRegCopia=c.nReg JOIN libro l ON c.edizioneLibro=l.edizione AND c.isbnLibro=l.isbn WHERE mailUtente='$usr' AND dataFine IS NOT null ";

        $query_prestitipassati_res = pg_query($con, $query_prestitipassati);

          if($query_prestitipassati_res){

            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover'>";
            echo "<thead><tr>";
            echo "<td><b>titolo</b></td>";
            echo "<td><b>isbn</b></td>";
            echo "<td><b>edizione</b></td>";
            echo "<td><b>data inizio</b></td>";
            echo "<td><b>data fine</b></td>";
            echo "<td><b>recensione</b></td>";

            echo "</thead></tr>";

            while($row = pg_fetch_assoc($query_prestitipassati_res)) {
              echo "<tbody><tr>";

              echo "<td>{$row['titolo']}</td>";
              echo "<td>{$row['isbn']}</td>";
              echo "<td>{$row['edizione']}</td>";
              echo "<td>{$row['datainizio']}</td>";
              echo "<td>{$row['datafine']}</td>";
              echo "<td><a href='valuta.php?Mail=".$usr."&NReg=".$row['nreg']."&Isbn=".$row['isbn']."&Edizione=".$row['edizione']."'>VALUTA LIBRO</a></td>";

              echo "</tbody></tr>";
            }

            echo "</table>";
            echo "</div>";

          } else {

            die("Errore nella query: " . pg_last_error($con));

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

// l'utente non e' riconosciuto
} else {
    
  unset($_SESSION["mail"]);
  unset($_SESSION["password"]);
  header("Location: index.html");

}
?>