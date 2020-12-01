<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
if(isset($_SESSION['id'])) {
    $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();   
 }
 ?>
  <html lang="en">
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
    <li><a href="../index.php">Home</a></li>
    <li><a href="">About</a></li>
    <li><a href="">Contact</a></li>
    <li><a href="inscription.php" class="btn white indigo-text">Inscription</a></li>
    <li><a href="connexion.php" class="btn white indigo-text">Login</a></li>
  </ul>
  
<main>

<h1>Les petits commentaires des sorciers et sorcières</h1>

<h2>Profil de <?php echo $userinfo['login']; ?></h2>
<?php

$requser = $bdd->prepare("SELECT date AS 'posté', login AS 'utilisateur', commentaire FROM `commentaires` INNER JOIN `utilisateurs` ON commentaires.id_utilisateurs = utilisateurs.id ORDER BY date DESC;");
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

<section class="commentaire">
<a href="commentaire.php" class="button" name="submit" type="submit">
<span>Laissez votre petit commentaire</span>
</a>   
</section>

<?php
if(isset($_POST['forminscription'])) {
        $commentaire = $_POST['commentaire'];
        if(!empty($commentaire))
        {
        date_default_timezone_get('Europe/Paris');
        $date =date("Y-m-d");
        $requetecom = $bdd->prepare("INSERT INTO  commentaires(commentaire, id_utilisateurs, date) VALUES(?, ?, ?)");
        $requetecom->execute(array($commentaire, $_SESSION['id'], $date));
        header("location:livre-or.php?id=".$_SESSION['id']);
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


<section class="commentaire">
  <form action="commentaire.php" method="post">
    <fieldset>
      <legend>Laisse un petit commentaire</legend>
      
        <article class="user-box">
          <label for="commentaire">Commentaire :</label>
          <textarea name="commentaire" rows=10 cols=80 placeholder="Votre petit commentaire magique!" ></textarea>
        </article>  

        <article class="user-box">
            <input type="submit" name="forminscription" value="Poster mon commentaire" />
        </article>
</fieldset>


<?php
if (isset($erreur))
{
  echo $erreur;
}
?>


</form>                                                                                              
</section>



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