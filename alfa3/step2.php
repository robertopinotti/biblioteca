<?php
session_start();

if (!isset($_SESSION["utente"]))
{
  echo "Non sei autorizzato ad accedere a questa pagina";
  exit;
}

$usr  = $_SESSION["utente"];
$pass = $_SESSION["password"];

if (isset($_POST["nome"])) $my_nome = $_POST["nome"];
if (isset($_POST["cognome"])) $my_cognome = $_POST["cognome"];
if (isset($_POST["sesso"])) $gender = $_POST["sesso"];
if (isset($_POST["hobby"])) $my_hobby =  $_POST["hobby"];
if (isset($_POST["condizioni"])) $cond = $_POST["condizioni"];

$msg="";
if (empty($my_nome))
   $msg = $msg . "<li>Manca il nome</li>\n";
if (empty($my_cognome))
   $msg = $msg . "<li>Manca il cognome</li>\n";
if (empty($gender))
   $msg = $msg . "<li>Manca Maschio/Femmina</li>\n";
if (empty($my_hobby))
   $msg = $msg . "<li>Devi specificare almeno un hobby</li>\n";
if (empty($cond))
   $msg = $msg . "<li>Devi accettare le condizioni</li>\n";

if ($msg!=""){
   $msg = "Attenzione torna indietro... " . $msg;
   echo $msg;
}
else
{
?>
<!-- Se e' andato tutto bene visualizzo in una tabella i risultati-->
  <table bgcolor="#dddddd" cellpadding="10">
  <tr><td>User</td> <td><?php echo $usr;?></td></tr>
  <tr><td>Password</td> <td><?php echo $pass;?></td></tr>
  <tr><td>Nome</td> <td><?php echo $my_nome;?></td></tr>
  <tr><td>Cognome</td> <td><?php echo $my_cognome;?></td></tr>
  <tr><td>Sesso</td> <td><?php
     if ($gender='M')
          echo 'Maschio';
     else echo 'Femmina';
  ?>
  </td></tr>
  <tr><td>Hobby</td><td>
  <SELECT>
  <?php
   foreach ( $my_hobby as $valore ) {
        echo "<OPTION>$valore </OPTION>";
   }
  ?>
  </SELECT>
  </td>
  </tr>
  <tr><td>Condizioni di utilizzo</td><td>Yes</td></tr>
  </table>
<?php
}
?>
