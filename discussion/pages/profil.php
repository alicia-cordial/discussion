<?php
session_start();
 
$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
 
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();

   
}
?>

<?php

 
if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newlogin']) AND !empty($_POST['newlogin']) AND $_POST['newlogin'] != $user['login']) {
      $newlogin = htmlspecialchars($_POST['newlogin']);
      $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
      $insertlogin->execute(array($newlogin, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND isset($_POST['newpassword2']) AND !empty($_POST['newpassword2'])) {
      $password = $_POST['newpassword'];
      $password2 = $_POST['newpassword2'];
      if($password == $password2) {
         $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
         $insertmdp->execute(array($password, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
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
    <li><a href="../index.php">Home</a></li>
    <li><a href="">About</a></li>
    <li><a href="">Contact</a></li>
    <li><a href="inscription.php" class="btn white indigo-text">Inscription</a></li>
    <li><a href="connexion.php" class="btn white indigo-text">Login</a></li>
  </ul>
  
<main>

<h1>Bienvenue<h1>
      <section class="infos">
         <h2>Profil de <?php echo $userinfo['login']; ?></h2>
      </section>
   
      <section class="profil">
            <form method="POST" action="" enctype="multipart/form-data">
              <fieldset>  
              <legend>Tes petites infos à modifier</legend>

              <article class="user-box">
                  <label>Login :</label>
                  <input type="text" name="newlogin" placeholder="login" value="<?php echo $user['login']; ?>" /><br /><br />
              </article>
               
                <article class="user-box">
                  <label>Mot de passe :</label>
                  <input type="password" name="newpassword" placeholder="Mot de passe"/><br /><br />
                </article>
                
                <article class="user-box"> 
                  <label>Confirmation - mot de passe :</label>
                  <input type="password" name="newpassword2" placeholder="Confirmation du mot de passe" /><br /><br />
                <article class="user-box">   

                <article class="user-box">
                  <input type="submit" value="Mettre à jour mon profil !" />
                <article class="user-box">
              </fieldset>  
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
      </section>

      <section class="deconnexion">
      <?php
      if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="deconnexion.php">Se déconnecter</a>
         <?php
         }
         ?>
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