<?php
session_start();
 
$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
 
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();

   
}

 
if(isset($_SESSION['id'])) {
  $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
  $requser->execute(array($_SESSION['id']));
  $user = $requser->fetch();
  if(isset($_POST['newlogin']) AND $_POST['newlogin'] != $user['login']) {
     $newlogin = htmlspecialchars($_POST['newlogin']);
     $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
     $insertlogin->execute(array($newlogin, $_SESSION['id']));
     header('Location: profil.php?id='.$_SESSION['id']);
  }
  if(isset($_POST['newpassword']) AND isset($_POST['newpassword2'])) {
     $password = sha1($_POST['newpassword']);
     $password2 = sha1($_POST['newpassword2']);
     if($password == $password2) {
        $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
        $insertmdp->execute(array($password, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
     } else {
        $msg = "Vos deux mdp ne correspondent pas !";
     }
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
  <title>Profil</title>
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
  


<h1>Bienvenue<h1>
  
    <h2 class="center">Profil de <?php echo $userinfo['login']; ?></h2>


<main class="valign-wrapper"> 
    
<div class="row">
  <form class="col s12" action="profil.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="input-field col s12">
          <input placeholder="newlogin" id="newlogin" type="text" name="newlogin"  maxlength="20" class="validate white-text" value="<?php echo $user['login']; ?>"/>
          <label for="newlogin">New Login</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
          <input id="newpassword" type="password" class="validate white-text" name="newpassword"  maxlength="20"/>
          <label for="newpassword">Nouveau Password</label>
        </div>
    </div>

    <div class="row">
      <div class="input-field col s12">
          <input id="newpassword2" type="password" class="validate white-text" name="newpassword2"  maxlength="20"/>
          <label for="newpassword2">Confirmation Password</label>
      </div>
    </div>

     
  <button class="btn waves-effect waves-light black" type="submit" name="formprofil">Submit
    <i class="material-icons right">send</i>
  </button>
        
<?php
if (isset($erreur))
{
  echo $erreur;
}
?>

    </form>
</div>

</main>




<section class="deconnexion">

<?php
    if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
?>
    <br />
    <a href="deconnexion.php" class="btn brown lighten-3">Se déconnecter</a>
    <a href="discussion.php" class="btn blue-grey">Discuter</a>
<?php
    }
?>

</section>


            
    <!-- Compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

<script>
$(document).ready(function(){
$('.sidenav').sidenav();
});
</script>

<script>

  $(document).ready(function() {
    $('input#input_text, textarea#textarea2').characterCounter();
  });
</script>    


</body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
?>