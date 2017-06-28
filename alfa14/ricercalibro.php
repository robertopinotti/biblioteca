<?php

  $con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=ciaone");

  if(!$con){
    echo "Errore nella connessione al database".pg_last_error($con);
    exit;
  }

  $Titolo = pg_escape_string($_POST['Titolo']);
  $Autore = pg_escape_string($_POST['Autore']);
  $CasaEd = pg_escape_string($_POST['CasaEd']);

?>

<!doctype html>
<html lang="it">

  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Elenco Libri | Biblioteca</title>
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
  <h2><span>Elenco Libri</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profiloutente.php">Profilo Utente</a></li>
  <li><a href="ricercalibro.html">Ricerca Libro</a></li>
  <li class="active">Elenco Libri</li>
</ul>

  <div class="row">

  <!-- PRESTITI PASSATI -->
    
  <div class="col-md-12">
    
    <div class="panel panel-default">

      <div class="panel-heading">
        <h3><strong>Libri Prenotabili</strong></h3>
      </div>

      <div class="panel-body">
        
        <?php

        $query = "
        SELECT DISTINCT l.titolo, l.edizione, l.isbn, l.nomecasaeditrice, l.datapubblicazione, avg(p.voto) AS MediaVoto, count(p.commento) AS Commenti
        FROM ((((libro AS l JOIN copia AS c ON ((l.isbn = c.isbnlibro) AND (l.edizione = c.edizionelibro))) 
                  LEFT JOIN prestito AS p ON (c.nreg = p.nregcopia))
                  JOIN scrive AS s ON ((l.isbn = s.isbnlibro) AND (l.edizione = s.edizionelibro)))
                  JOIN autore AS a ON (s.codautore = a.id) )
        WHERE ((l.titolo LIKE '%$_POST[Titolo]%') 
              AND (a.cognome LIKE '%$_POST[Autore]%')) 
            AND (l.nomecasaeditrice LIKE '%$_POST[CasaEd]%')
        GROUP BY (l.isbn, l.edizione, a.id)
        ORDER BY MediaVoto";

        $query_res = pg_query($con, $query);

        echo '<table class="table table-striped table-hover">';
        echo "\n\t<thead><tr>";

        echo "\n\t\t<td><b>titolo</b></td>";
        echo "\n\t\t<td><b>edizione</b></td>";
        echo "\n\t\t<td><b>isbn</b></td>";
        echo "\n\t\t<td><b>autore</b></td>";
        echo "\n\t\t<td><b>casa editrice</b></td>";
        echo "\n\t\t<td><b>data pubblicazione</b></td>";
        echo "\n\t\t<td><b>media voto</b></td>";
        echo "\n\t\t<td><b>commenti</b></td>";

        echo "\n\t</thead></tr>";

        while ($row = pg_fetch_array($query_res)) {

          echo "\n\t<tbody><tr>";

          $Titolo = $row[0]."\n";
          $Edizione = $row[1]."\n";
          $Isbn = $row[2]."\n";
          $CasaEd = $row[3]."\n";      
          $DataP = $row[4]."\n";
          $MediaVoto = $row[5]."\n";
          $Commenti = $row[6]."\n";

          echo "\n\t\t<td>".$Titolo."</td>";
          echo "\n\t\t<td>".$Edizione."</td>";
          echo "\n\t\t<td>".$Isbn."</td>";
          echo "\n\t\t<td>".$Autore."</td>";
          echo "\n\t\t<td>".$CasaEd."</td>";
          echo "\n\t\t<td>".$DataP."</td>";
          if($MediaVoto==0)
            echo "\n\t\t<td>--</td>";
          else
            echo "\n\t\t<td>".$MediaVoto."</td>";
          echo "\n\t\t<td>".$Commenti."</td>";
          echo "\n\t\t<td><a href='PrenotaLibro.php?Isbn=".$Isbn."&Edizione=".$Edizione."'>PRENOTA LIBRO</a></td>";

          echo "\n\t</tbody></tr>";

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