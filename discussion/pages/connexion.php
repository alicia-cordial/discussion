
 <?php
session_start();
 
$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
 
 
if(isset($_POST['formconnexion'])) 
{
   $loginconnect = htmlspecialchars($_POST['loginconnect']);
   $passwordconnect = sha1($_POST['passwordconnect']);
   if(!empty($loginconnect) AND !empty($passwordconnect)) 
   {
      $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
      $requser->execute(array($loginconnect, $passwordconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) 
      {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['login'] = $userinfo['login'];
         header("Location: profil.php?id=".$_SESSION['id']);
      }
       else {
         $erreur = "Mauvais login ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
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
  <title>Connexion</title>
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
  


<h1>Bienvenue sur ce site magique</h1>
<main class="valign-wrapper">
   <!--Formulaire-->      


   <div class="row">
    <form class="col s12" action="connexion.php" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input placeholder="login" id="loginconnect" type="text" name="loginconnect" class="validate white-text"/>
          <label for="login">Login</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="passwordconnect" type="password" class="validate white-text" name="passwordconnect" />
          <label for="password">Password</label>
        </div>
      </div>
 
     
  <button class="btn waves-effect waves-light black " type="submit" name="formconnexion">Submit
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