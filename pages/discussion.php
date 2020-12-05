<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
if(isset($_SESSION['id'])) {
    $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();   
 }
 ?>





  <html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  
  <link rel= "stylesheet" href= "../css/pages.css">
  <title>Discussion</title>
</head>
<body>

  <div class="navbar-fixed">
    <nav class="nav-wrapper black">
      <div class="container">
        <a href="#" class="brand-logo">Blue Moon
        <i class="material-icons text-white">brightness_4</i>
        </a>
        <a href="#" class="sidenav-trigger" data-target="mobile-links">
          <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down">
          <li><a href="../index.php">Home</a></li>
          <li><a href="">About</a></li>
          <li><a href="">Contact</a></li>
          <li><a href="inscription.php" class="btn white indigo-text">Inscription</a></li>
          <li><a href="connexion.php" class="btn white indigo-text">Login</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <ul class="sidenav" id="mobile-links">
    <li><a href="../index.php">Home
    <i class="material-icons">home </i>
    </a></li>
    <li><a href="">About
    <i class="material-icons">brightness_6 </i>
    </a></li>
    <li><a href="">Contact
    <i class="material-icons">mail_outline </i>
    </a></li>
    <li><a href="inscription.php" class="btn white indigo-text">Inscription</a></li>
    <li><a href="connexion.php" class="btn white indigo-text">Login</a></li>
  </ul>
  

<h1>Profil de <?php echo $userinfo['login']; ?></h1>


<main>
  <section class="valign-wrapper">

<?php

$requser = $bdd->prepare("SELECT date AS 'posté', login AS 'utilisateur', message FROM `messages` INNER JOIN `utilisateurs` ON messages.id_utilisateur = utilisateurs.id ORDER BY date DESC;");
$requser->execute();

$i=0;

echo "<table>" ;

while ($result = $requser->fetch(PDO::FETCH_ASSOC))
{
if ($i == 0)
{

foreach ($result as $key => $value)
{
echo "<th>$key</th>";
}
$i++;

}

echo "<tr>";
foreach ($result as $key => $value) {
if ($key == "posté"){
date_default_timezone_set('Europe/Paris');
$value =  date("d-m-Y", strtotime($value));  ;
echo "<td>$value</td>";
}
else
echo "<td>" .nl2br($value). "</td>";
}
echo "</tr>";
}

echo "</table>";

?>

<?php
if (isset($erreur))
{
echo $erreur;
}
?>

</form> 

  </section>
<?php
if(isset($_POST['forminscription'])) {
        $commentaire = htmlspecialchars($_POST['commentaire']);
        if(!empty($commentaire))
        {
        date_default_timezone_get('Europe/Paris');
        $date =date("Y-m-d");
        $requetecom = $bdd->prepare("INSERT INTO  messages(message, id_utilisateur, date) VALUES(?, ?, ?)");
        $requetecom->execute(array($commentaire, $_SESSION['id'], $date));
        header("location:discussion.php?id=".$_SESSION['id']);
        }
        else
        {
           $erreur;
        }
    }
    else
    {
        $erreur;
    }


?>

  <form action="discussion.php" method="post">
  
  <div class="row">
    <form class="col s12" action="discussion.php" method="post">
      <div class="row">
        <div class="input-field col s12">
          <textarea id="commentaire" class="materialize-textarea white-text" name="commentaire"></textarea>
          <label for="commentaire">Message</label>
        </div>
      </div>
    
      <button class="btn waves-effect waves-light black" type="submit" name="forminscription">Submit
    <i class="material-icons right">send</i>
  </button>
       
  </form>
</div>


<?php
if (isset($erreur))
{
  echo $erreur;
}
?>


</form>                                                                                              

</main>



  </footer>
            
    <!-- Compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){
        $('.sidenav').sidenav();
        });
    </script>
</body>
</html>