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

$con = pg_connect("host=localhost port=5432 dbname=esame  user=postgres password=ciaone");
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

    <title>Dipendente | Biblioteca</title>
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
    
  <div class="col-md-4">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3><strong>Dati utente</strong></h3>
      </div>
      <div class="panel-body">
        Panel content
      </div>
    </div>

  </div> <!-- <div class="col-md-4"> -->

  <!-- MODIFICA DB -->

  <div class="col-md-4">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3><strong>Prenota libro</strong></h3>
      </div>
      <div class="panel-body">
        Panel content
      </div>
    </div>

  </div> <!-- <div class="col-md-4"> -->

  <!-- PRESTITI -->

  <div class="col-md-4">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3><strong>Prenota libro</strong></h3>
      </div>
      <div class="panel-body">
        Panel content
      </div>
    </div>

  </div> <!-- <div class="col-md-4"> -->

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
    header("Location: index.php");
}
?>