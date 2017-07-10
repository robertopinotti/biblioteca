<?php

  $con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=unimi");

  if(!$con){
    echo "Errore nella connessione al database".pg_last_error($con);
    exit;
  }

  $Isbn = $_GET['Isbn'];
  $Edizione = $_GET['Edizione'];

?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Commenti Libro | Biblioteca</title>
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
  <h2><span>Commenti Libro</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profiloutente.php">Profilo Utente</a></li>
  <li><a href="ricercalibro.html">Ricerca Libro</a></li>
  <li><a href="ricercalibro.php">Elenco Libri</a></li>
  <li class="active">Commenti Libro</li>
</ul>

  <div class="row">

  <!-- PRESTITI PASSATI -->
    
  <div class="col-md-12">
    
    <div class="panel panel-default">

      <div class="panel-heading">
        <h3><strong>Commenti Libro</strong></h3>
      </div>

      <div class="panel-body">
        
        <?php

        $query = "SELECT commento, voto
                  FROM prestito p JOIN copia c ON p.nregcopia=c.nreg
                                  JOIN libro l ON l.isbn=c.isbnlibro AND l.edizione=c.edizionelibro
                  WHERE ((voto IS NOT NULL)
                        AND (c.isbnlibro = '$Isbn') 
                        AND (c.edizionelibro = '$Edizione'))
                ";

        $query_res = pg_query($con, $query);

        echo "<table class='table table-striped table-hover'>";
        echo "<thead><tr>";

        echo "<td><b>commento</b></td>";
        echo "<td><b>voto</b></td>";

        echo "</thead></tr>";

        while ($row = pg_fetch_array($query_res)) {

          echo "<tbody><tr>";

          $Commento = $row[0];
          $Voto = $row[1];

          echo "<td>".$Commento."</td>";
          // echo "<td>".$Voto."</td>";

          echo "<td>";
          $i=0;
          for (; $i < $Voto; $i++) { 
            echo "<span class='glyphicon glyphicon-star' aria-hidden='true'></span>";
          }
          for (; $i < 5; $i++) { 
            echo "<span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>";
          }
          echo "</td>";

          echo "</tbody></tr>";

        }

        echo "</table>";
          
        ?>

      </div>

    </div> <!-- <div class="panel panel-default"> -->

  </div> <!-- <div class="col-md-12"> -->

  </div> <!-- <div class="row"> -->

</div> <!-- <div class="container"> -->

</body>
</html>