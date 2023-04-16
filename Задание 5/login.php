<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

if(isset($_COOKIE["init"])){
  setcookie("init", "", 1000000);
  $_SESSION['login']="";
}

if(!empty($_SESSION['login'])){
  header('Location: index.php'); 
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style_login.css" />
    <title>WEB 5</title>
  </head>

  <body>
    <form method="POST" action="login.php">
    <div class="container">
      <div style="margin-bottom: 20px; color:red; <?php
      if(!isset($_COOKIE["info"])){
        echo "display: none;";
      }
      ?>">Неверный логин или пароль</div>
    <div class="inputs">
        <label style="margin-left:10px; font-size: 15px; font-family: 'Montserrat';">Логин</label>
        <input type="text" name="login" placeholder="Введите логин" value="<?php
        if(isset($_COOKIE["login"])){
          echo $_COOKIE["login"];
        }
        ?>" required/>
        <label style="margin-left:10px; font-size: 15px; font-family: 'Montserrat';">Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль" value="<?php
        if(isset($_COOKIE["password"])){
          echo $_COOKIE["password"];
        }
        ?>" required/>
        <button type="submit">ВОЙТИ</button>
    </div>
    <a href="index.php">Войти без авторизации</a>
    </div>
  </form>
  </body>
</html>

<?php
}
else {
  $user = 'u52879';
  $pass = '2750849';
  $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
  $login=$_POST["login"];
  $password=$_POST["password"];
  $password_old=md5($password);
  $sth = $conn->prepare("SELECT id, login, password, id_form FROM USERS where login=:login and password=:password");
  $sth->execute(['login'=>"$login", 'password'=>"$password_old"]);
  $result = $sth->fetchAll();
  setcookie("login", $login);
  setcookie("password", $password);
  setcookie("info", "error");

  if(!empty($result)){
    $_SESSION['login'] = $login;
    $_SESSION['id'] = $result[0]['id'];
    $_SESSION['id_form']=$result[0]['id_form'];
    $_SESSION['password']=$password;
    setcookie("info", "", 1000000);
  }
  header('Location: login.php');
  exit();
}
?>