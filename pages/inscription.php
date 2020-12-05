<?php


$bdd = new PDO('mysql:host=localhost;dbname=discussion', 'root', '');
 
$login = htmlspecialchars($_POST['login']);
$password = sha1($_POST['password']);
$password2 = sha1($_POST['password2']);  

if(isset($_POST['forminscription'])) {
        $requetelogin= $bdd->prepare("SELECT login FROM utilisateurs WHERE login =?;");
        $requetelogin->execute(array($login));
        $loginexist= $requetelogin->rowCount();

            if($loginexist==0){
                if($password == $password2) {
                    $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(login, password) VALUES(?, ?)");
                    $insertmbr->execute(array($login, $password));
                    $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
            }
            else {
                $erreur = "Vos mots de passes ne correspondent pas !";
                }
              }
}?>


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
  <title>Inscription</title>
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

  <h1>Bienvenue à toutes</h1>
  
<main class="valign-wrapper">

    
        <!--FORMULAIRE--> 
      

<div class="row">
  <form class="col s12" action="inscription.php" method="post">
    <div class="row">
        <div class="input-field col s12">
          <input placeholder="login" id="login" type="text" name="login" class="validate white-text" value="<?php if(isset($login)) { echo $login; } ?>" maxlength="20" required/>
          <label for="login">Login</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" class="validate white-text" name="password" maxlength="20" required/>
          <label for="password">Password</label>
        </div>
    </div>

    <div class="row">
      <div class="input-field col s12">
          <input id="password2" type="password" class="validate white-text" name="password2" maxlength="20" required/>
          <label for="password2">Confirmation Password</label>
      </div>
    </div>

     
  <button class="btn waves-effect waves-light black" type="submit" name="forminscription">Submit
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