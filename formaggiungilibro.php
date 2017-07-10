<?php

session_start();

// connessione al database
$con = pg_connect("host=localhost port=5432 dbname=biblioteca  user=postgres password=unimi");

// se la connessione è andata male
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

		<title>Aggiungi Libro | Biblioteca</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
		<link href="css/bootstrap-united.css" rel="stylesheet">
		

  		<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
  		<script src="js/vendor/bootstrap.js"></script>
  		<script src="js/vendor/bootstrap.min.js"></script>
  		<script src="js/vendor/jquery-1.11.2.js"></script>
  		<script src="js/vendor/plugin.js"></script>
  		<script src="js/vendor/npm.js"></script>
    
	<style type="text/css">
		body {
			padding-bottom: 50px;
		}
		img{
	      width: 100%;
	    }    
	    h1 {
	      position: absolute;
	      top: 50px;
	      left: 50px;

	    }
	    @media (max-width:768px){
	    	h1 {
		      	top: -10px;
		      	left: 10px;
		      	font-size: 190%;
	    	}
	    }
	    h1 span { 
	      color: white;
	      background: rgba(0, 0, 0, 0.7); 
	    }
		.container {
			padding-top: 10px;
		}
		.jumbotron {
			padding-top: 10px;
		}
		fieldset {
			padding: 20px;
			background-color: #F6F6F6;
			border-radius: 10px;
		}
	</style>
	
</head>
<body>

<div class="image">
  <img src="image/biblioteca2.jpg" class="img-responsive" alt="Responsive image">  
  <h1><span>Aggiungi Libro</span></h1>
</div>

<div class="container">

<ul class="breadcrumb">
  <li><a href="profilodipendente.php">Profilo Dipendente</a></li>
  <li class="active">Aggiungi Libro</li>
</ul>

<div class="row">
	
	<div class="col-md-8">

		<form class="form-horizontal" action="aggiungilibro.php" method="POST">

		  <fieldset>

		   <legend>Dati Libro</legend>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">Titolo*</label>
		      <div class="col-md-10">
		        <input type="text" class="form-control" name="Titolo" value="" placeholder="Titolo libro" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">ID autore*</label>
		      <div class="col-md-10">
		        <input type="int" class="form-control" name="Autore" value="" placeholder="ID Autore 1" required/>
		        <br/>
		        <input type="int" class="form-control" name="Autore1" value="" placeholder="ID Autore 2" />
		        <br/>
		        <input type="int" class="form-control" name="Autore2" value="" placeholder="ID Autore 3" />
		        <br/>
		        <input type="int" class="form-control" name="Autore3" value="" placeholder="ID Autore 4" />
		        <br/>
		        <input type="int" class="form-control" name="Autore4" value="" placeholder="ID Autore 5" />
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">Casa editrice*</label>
		      <div class="col-md-10">
		        <input type="text" class="form-control" name="CasaEd" value="" placeholder="Nome casa editrice" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">Edizione*</label>
		      <div class="col-md-10">
		        <input type="int" class="form-control" name="Edizione" value="" placeholder="Edizione del libro" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">ISBN*</label>
		      <div class="col-md-10">
		        <input type="text" class="form-control" name="Isbn" value="" placeholder="ISBN del libro" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="data" class="col-md-2 control-label">Data pubblicazione*</label>
		      <div class="col-md-10">
		        <input type="date" class="form-control" name="DataP" value="" required/><br/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="data" class="col-md-2 control-label">Lingua*</label>
		      <div class="col-md-10">
		        <input type="text" class="form-control" name="lingua" value="" placeholder="it/en/..." required/><br/>
		      </div>
		    </div>

		    <legend>Copie</legend>

		    <div class="form-group">
		      <label for="int" class="col-md-2 control-label">Copie del libro*</label>
		      <div class="col-md-10">
		        <input type="int" class="form-control" name="NCopie" value="1" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="int" class="col-md-2 control-label">Scaffale*</label>
		      <div class="col-md-10">
		        <input type="int" class="form-control" name="Scaf" value="" placeholder="Numero dello scaffale" required/>
		      </div>
		    </div>

		    <div class="form-group">
		      <label for="text" class="col-md-2 control-label">Sezione*</label>
		      <div class="col-md-10">
		        <input type="text" class="form-control" name="Sez" value="" placeholder="Nome della sezione" required/>
		      </div>
		    </div>

		    *obbligatorio

		   </fieldset> <br/>

		    <div class="form-group">
		      	<div class="col-md-10 col-md-offset-2">
		        	<button type="reset" class="btn btn-default">Pulisci form</button>
		        	<button type="submit" class="btn btn-primary">Aggiungi Libro</button>
		    	</div>
		    </div>

		</form>

	</div> <!-- <div class="col-md-8"> -->

	<div class="col-md-4">

	<fieldset>

	<legend>Autori</legend>

	<?php

		echo "<form action='aggiungiautore.html'>
		<button type='submit' class='btn btn-primary btn-block'>AGGIUNGI AUTORE</button> </form>";

		$query_autore = "SELECT * FROM autore";

		$query_autore_res = pg_query($con, $query_autore);

		if ($query_autore_res) {

			echo "<div class='table-responsive'>";
			echo "<table class='table table-striped table-hover'>";
	        echo "<thead><tr>";
	        echo "<td><b>autore</b></td>";
	        echo "<td><b>ID</b></td>";
	        echo "</thead></tr>";

	        while($row = pg_fetch_assoc($query_autore_res)) {
	        	echo "<tbody><tr>";
	            echo "<td>{$row['cognome']}</td>";
	            echo "<td>{$row['id']}</td>";
	            echo "</tbody></tr>";
	        }

	        echo "</table>";
	        echo "</div>";
			
		} else {
			die("Errore nella query: " . pg_last_error($con));
		}

	 ?>

	 </fieldset>

	 <fieldset>

	<legend>Case Editrici</legend>

	<?php

		echo "<form action='aggiungicasaed.html'>
		<button type='submit' class='btn btn-primary btn-block'>AGGIUNGI CASA ED</button> </form>";

		$query_casaed = "SELECT * FROM casaeditrice";

		$query_casaed_res = pg_query($con, $query_casaed);

		if ($query_casaed_res) {

			echo "<div class='table-responsive'>";
			echo "<table class='table table-striped table-hover'>";
	        echo "<thead><tr>";
	        echo "<td><b>nome</b></td>";
	        echo "</thead></tr>";

	        while($row = pg_fetch_assoc($query_casaed_res)) {
	        	echo "<tbody><tr>";
	            echo "<td>{$row['nome']}</td>";
	            echo "</tbody></tr>";
	        }

	        echo "</table>";
	        echo "</div>";
			
		} else {
			die("Errore nella query: " . pg_last_error($con));
		}

	 ?>

	 </fieldset>

	</div> <!-- <div class="col-md-4"> -->

</div> <!-- <div class="row"> -->
</div> <!-- <div class="container"> -->

</body>
</html>