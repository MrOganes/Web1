<?php

include('module.php');

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_COOKIE['init'])){
  DEL_COOKIE();
  header("Location: admin.php");
  exit();
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}
else{
  $conn=DB_link();
  $result = DB_ADMINS($conn, $_SERVER['PHP_AUTH_USER']);
  $pass = $_SERVER['PHP_AUTH_PW'];
  $flag = false;
  foreach($result as $cout){
    if(password_verify($pass,$cout["pass"])){
      $flag = true;
    }
  }

  if(!$flag){
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  else{
    $users = DB_USERS($conn);
    
    ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WEB 6</title>
    <link rel="stylesheet" href="style_admin.css" />
  </head>

  <body>
    <a id="mes"><b>Вы успешно авторизовались и видите защищенные паролем данные.</b></a>
    <a></br><b>Статистика:<b></a>
    <table>
        <tr>
          <th>Суперспособность</th>
          <th>Кол-во человек</th>
        </tr>
      <?php
        $kol = Kol_immortality($conn);
        echo "<tr><td>immortality</td><td class='center'>$kol</td>";
        $kol =  Kol_passing_through_walls($conn);
        echo "<tr><td>passing through walls</td><td class='center'>$kol</td>";
        $kol =  Kol_levitation($conn);
        echo "<tr><td>levitation</td><td class='center'>$kol</td>";
      ?>
    </table>
    <a></br></br><b>Пользователи:</b></a>
      <table>
        <tr>
          <th>id</th>
          <th>login</th>
        </tr>
        <?php
        foreach($users as $cout){
          $id = $cout['id'];
          $log = $cout['login'];
          echo "<tr><td>$id</td><td>$log</td>";
          echo "<td><form action='index.php' method='GET'><button value='$id' name='but' type='submit'>Изменить</button></form></td>";
          echo "<td><form action='del.php' method='POST' target: '_blank'><button value='$id' name='but' type='submit'>Удалить</button></form></td></tr>";
        }
        ?>
      </table>
  </body>
</html>
    <?php
    exit();    
  }
}
?>