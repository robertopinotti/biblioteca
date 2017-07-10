<?php

  $con = pg_connect("host=localhost port=5432 dbname=biblioteca user=postgres password=unimi");

  if(!$con){
    echo "Errore nella connessione al database".pg_last_error($con);
    exit;
  }

  $Titolo = pg_escape_string($_POST['Titolo']);
  $Autore = pg_escape_string($_POST['Autore']);
  $CasaEd = pg_escape_string($_POST['CasaEd']);
  $Lingua = pg_escape_string($_POST['Lingua']);

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
  <h2><span>Elenco Libri</span></h2>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profiloutente.php">Profilo Utente</a></li>
  <li><a href="ricercalibro.html">Ricerca Libro</a></li>
  <li class="active">Elenco Libri</li>
</ul>

  <div class="row">
  <div class="col-md-12">
    
    <div class="panel panel-default">

      <div class="panel-heading">
        <h3><strong>Libri Prenotabili</strong></h3>
      </div>

      <div class="panel-body">
        
        <?php

        $query = "
        SELECT DISTINCT l.titolo, l.edizione, l.isbn, l.nomecasaeditrice, l.datapubblicazione, l.lingua, round(avg(p.voto),1) AS MediaVoto, count(p.commento) AS Commenti, a.cognome
        FROM ((((libro AS l JOIN copia AS c ON ((l.isbn = c.isbnlibro) AND (l.edizione = c.edizionelibro))) 
                  LEFT JOIN prestito AS p ON (c.nreg = p.nregcopia))
                  JOIN scrive AS s ON ((l.isbn = s.isbnlibro) AND (l.edizione = s.edizionelibro)))
                  JOIN autore AS a ON (s.codautore = a.id) )
        WHERE ((l.titolo LIKE '%$_POST[Titolo]%') 
              AND (a.cognome LIKE '%$_POST[Autore]%')
              AND (l.nomecasaeditrice LIKE '%$_POST[CasaEd]%')
              AND (l.lingua LIKE '%$_POST[Lingua]%'))
        GROUP BY (l.isbn, l.edizione, a.id)
        ORDER BY MediaVoto";

        $query_res = pg_query($con, $query);

          echo "<div class='table-responsive'>";
          echo "<table class='table table-striped table-hover'>";
          echo "<thead><tr>";
          echo "<td><b>ttitolo</b></td>";
          echo "<td><b>edizione</b></td>";
          echo "<td><b>isbn</b></td>";
          echo "<td><b>autore</b></td>";
          echo "<td><b>casa editrice</b></td>";
          echo "<td><b>data pubblicazione</b></td>";
          echo "<td><b>lingua</b></td>";
          echo "<td><b>media voto</b></td>";
          echo "<td><b>commenti</b></td>";
          echo "</thead></tr>";

          while ($row = pg_fetch_array($query_res)) {

            $Titolo = $row[0]."";
            $Edizione = $row[1]."";
            $Isbn = $row[2]."";
            $CasaEd = $row[3]."";      
            $DataP = $row[4]."";
            $Lingua = $row[5]."";
            $MediaVoto = $row[6]."";
            $Commenti = $row[7]."";
            $Autore = $row[8]."";

            echo "<tbody><tr>";
            echo "<td>".$Titolo."</td>";
            echo "<td>".$Edizione."</td>";
            echo "<td>".$Isbn."</td>";
            echo "<td>".$Autore."</td>";
            echo "<td>".$CasaEd."</td>";
            echo "<td>".$DataP."</td>";
            echo "<td>".$Lingua."</td>";
            if($MediaVoto==0)
              echo "<td>--</td>";
            else
              echo "<td>".$MediaVoto."</td>";
            if ($Commenti>0)
              echo "<td><a href='commentilibro.php?Isbn=".$Isbn."&Edizione=".$Edizione."'>".$Commenti."</a></td>";
            else
              echo "<td>".$Commenti."</td>";
            echo "<td><a href='prenotalibro.php?Isbn=".$Isbn."&Edizione=".$Edizione."'>PRENOTA LIBRO</a></td>";

            echo "</tbody></tr>";

          }

          echo "</table>";
          echo "</div>";
          
        ?>

      </div> <!-- <div class="panel-body"> -->

    </div> <!-- <div class="panel panel-default"> -->

</div> <!-- <div class="col-md-12"> -->
</div> <!-- <div class="row"> -->
</div> <!-- <div class="container"> -->

</body>
</html>