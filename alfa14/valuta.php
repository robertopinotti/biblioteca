<?php

$con = pg_connect('host=localhost port=5432 dbname=biblioteca user=postgres password=ciaone');

if(!$con){
	echo 'Errore nella connessione al database'.pg_last_error($con);
	exit;
}

$Mail = $_GET['Mail'];
$NReg = $_GET['NReg'];
$Isbn = $_GET['Isbn'];
$Edizione = $_GET['Edizione'];

?>

<!doctype html>
<html lang='it'>

	<head>    
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>

		<title>Valuta Libro | Biblioteca</title>
		<meta name='description' content=''>
		<meta name='author' content=''>
		<link rel='icon' href='../../favicon.ico'>

		<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>
		<link href='css/bootstrap-united.css' rel='stylesheet'>
		
  		<script src='js/vendor/modernizr-2.8.3-respond-1.4.2.min.js'></script>
  		<script src='js/vendor/bootstrap.js'></script>
  		<script src='js/vendor/bootstrap.min.js'></script>
  		<script src='js/vendor/jquery-1.11.2.js'></script>
  		<script src='js/vendor/plugin.js'></script>
  		<script src='js/vendor/npm.js'></script>
  		<script src='countries.js'></script>
    
	<style type='text/css'>
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
	    h1 span { 
	      color: white;
	      background: rgba(0, 0, 0, 0.7); 
	    }
		.container {
			padding-top: 10px;
		}
	</style>
	
</head>
<body>

<div class='image'>
  <img src='image/biblioteca2.jpg' class='img-responsive' alt='Responsive image'>  
  <h1><span>Valuta Libro</span></h1>
</div>

<div class='container'>

<ul class='breadcrumb'>
  <li><a href='profiloutente.php'>Profilo Utente</a></li>
  <li class='active'>Valuta Libro</li>
</ul>

<?php

$query = "
		SELECT DISTINCT p.mailutente, p.nregcopia, l.titolo

        FROM ((prestito AS p JOIN copia AS c ON (p.nregcopia = c.nreg))
          	JOIN libro AS l ON ((l.isbn = c.isbnlibro) AND (l.edizione = c.edizionelibro)))

        WHERE ((p.mailutente ='$Mail') 
	    	    AND (l.isbn = '$Isbn')
				AND (l.edizione ='$Edizione')
				AND (p.voto IS NOT NULL))";

$query_res = pg_query($con, $query);

if(!$query_res){ 
	echo 'Errore nella query '.pg_last_error();
}

if(!pg_fetch_array($query_res)){

echo "
		
	<div class='row'>

	<div class='col-md-6'>

		<form class='form-horizontal' action='votolibro.php?NReg=".$NReg."' method='POST'>

		  <fieldset>

		  <legend>Stai valutando <i>".$Isbn."</i></legend>

		  	<div class='form-group'>
		      <label class='col-md-2 control-label'>Voto</label>
		      <div class='col-md-10'>

		        <div class='radio'>
		          <label>
		            <input type='radio' name='Voto' value='1'>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		          </label>

		          <br/>
		        
		          <label>
		            <input type='radio' name='Voto' value='2'>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		          </label>

		          <br/>

		          <label>
		            <input type='radio' name='Voto' value='3'>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		          </label>

		          <br/>

		          <label>
		            <input type='radio' name='Voto' value='4'>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
		          </label>

		          <br/>

		          <label>
		            <input type='radio' name='Voto' value='4' checked>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
		          </label>
		        </div>

		      </div>
		    </div>   

		    <div class='form-group'>
		      <label for='textArea' class='col-md-2 control-label'>Recensione</label>
		      <div class='col-md-10'>
		        <textarea type='text' class='form-control' name='Commento' value='' placeholder='Inserisci una recensione' required='' /></textarea>
		      </div>
		    </div>

		   </fieldset> <br/>

		    <div class='form-group'>
		      	<div class='col-md-10 col-md-offset-2'>
		        	<button type='reset' class='btn btn-default'>Pulisci form</button>
		        	<button type='submit' class='btn btn-primary'>Valuta libro</button>
		    	</div>
		    </div>

		</form>

	</div> <!-- <div class='col-md-6'> -->

	</div> <!-- <div class='row'> -->

";

} else {

	echo "<div class='jumbotron'>";
	echo "<p>Hai già valutato questo libro, <a href='profiloutente.php'>torna indietro</a></p>";
	echo "</div>";

}

?>
</div> <!-- <div class='container'> -->

</body>
</html>