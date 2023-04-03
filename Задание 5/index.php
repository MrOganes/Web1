<?php
header('Content-Type: text/html; charset=UTF-8');
$rez="";

function test_name($data){
  $pattern = '/^[а-яё]+$/iu';
  if (preg_match($pattern, $data)) {
    return true;
  } else {
    return false;
  }
}

function test_email($data){
  $pattern = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';
  if (preg_match($pattern, $data)) {
    return true;
  } else {
    return false;
  }
}

function test_biography($data){
  $pattern = '/^[а-яёa-z0-9 .]+$/i';
  if (preg_match($pattern, $data)) {
    return true;
  } else {
    return false;
  }
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
  if(!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login']) && !isset($_COOKIE['init'])){
    if (isset($_COOKIE["nameErr"])) {
      setcookie("nameErr", "", 1000000);
    }
    if(isset($_COOKIE["emailErr"])){
      setcookie("emailErr", "", 1000000);
    }
    if(isset($_COOKIE["genderErr"])){
      setcookie("genderErr", "", 1000000);
    }
    if(isset($_COOKIE["kolErr"])){
      setcookie("kolErr", "", 1000000);
    }
    if(isset($_COOKIE["superpowersErr"])){
      setcookie("superpowersErr", "", 1000000);
    }
    if(isset($_COOKIE["biographyErr"])){
      setcookie("biographyErr", "", 1000000);
    }
    if(isset($_COOKIE["ok"])){
      setcookie("ok", "", 1000000);
    }
    $user = 'u52879';
    $pass = '2750849';
    $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
    $sth = $conn->prepare("SELECT name, email, year, gender, limbs, biography FROM FORMS where id=:id");
    $id = $_SESSION["id_form"];
    setcookie("id_form", $id);
    $sth->execute(['id'=>"$id"]);
    $result = $sth->fetchAll();
    setcookie("name", $result[0]['name']);
    setcookie("email", $result[0]["email"]);
    setcookie("year", $result[0]["year"]);
    setcookie("gender", $result[0]["gender"]);
    setcookie("kol", $result[0]["limbs"]);
    setcookie("biography", $result[0]["biography"]);

    $id = $_SESSION["id_superpowers"];
    setcookie("id_super", $id);
    $sth2 = $conn->prepare("SELECT immortality, passing_through_walls, levitation FROM SUPERPOWERS where KEY_DATA=:KEY_DATA");

    $sth2->execute(['KEY_DATA'=>"$id"]);
    $result_super = $sth2->fetchAll();
    if($result_super[0]["immortality"]=="yes"){
      setcookie("immortality", "yes");
    }
    else{
      setcookie("immortality", "",1000000);
    }
    if($result_super[0]["passing_through_walls"]=="yes"){
      setcookie("passing_through_walls","yes");
    }
    else{
      setcookie("passing_through_walls","",1000000);
    }
    if($result_super[0]["levitation"]=="yes"){
      setcookie("levitation","yes");
    }
    else{
      setcookie("levitation","",1000000);
    }
    setcookie("init", "good");
    header('Location: index.php');
    exit();
  }
  include('form.php');
  exit();
}
else{
  $error=FALSE;
    if (empty($_POST["name"])) {
      setcookie("nameErr","Введите имя!");
      setcookie("name",$_POST["name"]);
      $error=TRUE;
    } else {
      if(test_name($_POST["name"])){
        setcookie("nameErr","",1000000);
        setcookie("name",$_POST["name"]);
      }
      else{
        $error=TRUE;
        setcookie("nameErr", "Имя должно содержать только символы а-я.");
        setcookie("name",$_POST["name"]);
      }
    }
  
    if(empty($_POST["email"])){
      setcookie("emailErr","Введите email!");
      setcookie("email", $_POST["email"]);
      $error=TRUE;
    }
    else{
      if(test_email($_POST["email"])){
        setcookie("email",$_POST["email"]);
        setcookie("emailErr","",1000000);
      }
      else{
        $error=TRUE;
        setcookie("emailErr","Недопустимые символы при вводе email.");
        setcookie("email",$_POST["email"]);
      }
    }

    setcookie("year",$_POST["year"]);
    
  
    if(empty($_POST["pol"])){
      $error=TRUE;
      setcookie("genderErr","Укажите пол!");
    }
    else{
      setcookie("genderErr","",1000000);
      if($_POST["pol"]=="Мужской"){
        setcookie("gender", "Мужской");
      }
      else{
        setcookie("gender", "Женский");
      }
    }
  
    if(empty($_POST["kol"])){
      $error=TRUE;
      setcookie("kolErr","Укажите кол-во конечностей!");
    }
    else{
      setcookie("kol",$_POST["kol"]);
      setcookie("kolErr","",1000000);
    }
  
    if(empty($_POST["superpowers"])){
      $error=TRUE;
      setcookie("superpowersErr","Укажите сверхспособности!");
      setcookie("superpowers",$_POST["superpowers"]);
    }
    else{
      setcookie("superpowersErr","",1000000);
      setcookie("immortality","",1000000);
      setcookie("passing_through_walls","",1000000);
      setcookie("levitation","",1000000);
      $superpowers=$_POST["superpowers"];
      foreach($superpowers as $cout){
        if($cout =="бессмертие"){
          setcookie("immortality","yes");
        }
        if($cout =="прохождение сквозь стены"){
          setcookie("passing_through_walls","yes");
        }
        if($cout =="левитация"){
          setcookie("levitation","yes");
        }
      }
    }
  
    if(empty($_POST["biography"])){
      $error=TRUE;
      setcookie("biographyErr","Заполните биографию!");
      setcookie("biography",$_POST["biography"]);
    }
    else{
      if(test_biography($_POST["biography"])){
        setcookie("biographyErr","",1000000);
        setcookie("biography",$_POST["biography"]);
      }
      else{
        $error=TRUE;
        setcookie("biographyErr","При заполнении биографии доступны только символы а-я, a-z, 0-9.");
        setcookie("biography",$_POST["biography"]);
      }
    }

    if(empty($_POST["ok"])){
      $error=TRUE;
      setcookie("ok","Примите правила компании!");
    }
    else{
      setcookie("ok","",1000000);
    }


    if($error){
      header("Location: index.php");
      exit();
    }
    else{
      setcookie("name",$_POST["name"], time()+60*60*24*365);
      setcookie("email", $_POST["email"], time()+60*60*24*365);
      setcookie("year",$_POST["year"], time()+60*60*24*365);
      if($_POST["pol"]=="Мужской"){
        setcookie("gender", "Мужской", time()+60*60*24*365);
      }
      else{
        setcookie("gender", "Женский", time()+60*60*24*365);
      }
      setcookie("kol",$_POST["kol"], time()+60*60*24*365);
      $immortality='no';
      $passing_through_walls='no';
      $levitation='no';
      foreach($superpowers as $cout){
        if($cout =="бессмертие"){
          setcookie("immortality","yes", time()+60*60*24*365);
          $immortality="yes";
        }
        if($cout =="прохождение сквозь стены"){
          setcookie("passing_through_walls","yes", time()+60*60*24*365);
          $passing_through_walls="yes";
        }
        if($cout =="левитация"){
          setcookie("levitation","yes", time()+60*60*24*365);
          $levitation="yes";
        }
      }
      setcookie("biography",$_POST["biography"], time()+60*60*24*365);

      $name = $_POST["name"];
      $email = $_POST["email"];
      $year = $_POST["year"];
      $gender = $_POST["pol"];
      $kol = $_POST["kol"];
      $biography=$_POST["biography"];

      $user = 'u52879';
      $pass = '2750849';
      $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

      if(!isset($_COOKIE["init"])){
        $stmt = $conn->prepare("INSERT INTO FORMS(name, email, year, gender, limbs, biography) VALUES (:name, :email, :year, :gender, :limbs, :biography)");
        $rez=$stmt->execute(['name'=>"$name",'email'=>"$email", 'year'=>"$year", 'gender'=>"$gender", 'limbs'=>"$kol", 'biography'=>"$biography"]);
        $id_form=$conn->lastInsertId();
        $stmt2=$conn->prepare("INSERT INTO SUPERPOWERS(immortality, passing_through_walls,levitation) VALUES (:immortality, :passing_through_walls, :levitation)");
        $rez2=$stmt2->execute(['immortality'=>"$immortality", 'passing_through_walls'=>"$passing_through_walls", 'levitation'=>"$levitation"]);
        $id_super=$conn->lastInsertId();
        $stmt3=$conn->prepare("INSERT INTO FORM_SUPERPOWER(id_DATA_FORM, id_DATA_superpower) VALUES (:id_DATA_FORM, :id_DATA_superpower)");
        $rez3=$stmt3->execute(['id_DATA_FORM'=>"$id_form", 'id_DATA_superpower'=>"$id_super"]);

        $bytes_log = openssl_random_pseudo_bytes(4);
        $bytes_pass = openssl_random_pseudo_bytes(5);
        $log = bin2hex($bytes_log);
        $pass_komb = bin2hex($bytes_pass);
        $pass = md5($pass_komb);
        $stmt4=$conn->prepare("INSERT INTO USERS(login, password, id_form, id_superpowers) VALUES (:login, :password, :id_form, :id_superpowers)");
        $rez4=$stmt4->execute(['login'=>"$log", 'password'=>"$pass", 'id_form'=>"$id_form", 'id_superpowers'=>"$id_super"]);
        setcookie("login_new",$log);
        setcookie("password_new", $pass_komb);
        if($rez==1 && $rez2==1 && $rez3==1 && $rez4==1){
          setcookie("mark", "good");
        }
        else{
          setcookie("mark","bad");
        }  
      }
      else{
          $stmt5 = $conn->prepare("UPDATE FORMS SET name = :name, email = :email, year = :year, gender = :gender, limbs = :limbs, biography = :biography WHERE id = :id");
          $rez5 = 0;
          $stmt5->bindValue(":id", $_COOKIE['id_form']);
          $stmt5->bindValue(":name", $name);
          $stmt5->bindValue(":email", $email);
          $stmt5->bindValue(":year", $year);
          $stmt5->bindValue(":gender", $gender);
          $stmt5->bindValue(":limbs", $kol);
          $stmt5->bindValue(":biography", $biography);
          $rez5=$stmt5->execute();
          
          $stmt6 = $conn->prepare("UPDATE SUPERPOWERS SET immortality = :immortality, passing_through_walls = :passing_through_walls, levitation = :levitation WHERE KEY_DATA = :id");
          $rez6 = 0;
          $stmt6->bindValue(":id", $_COOKIE["id_super"]);
          $stmt6->bindValue(":immortality", "$immortality");
          $stmt6->bindValue(":passing_through_walls", "$passing_through_walls");
          $stmt6->bindValue(":levitation", "$levitation");
          $rez6=$stmt6->execute();

        if($rez5!=0 && $rez6!=0){
          setcookie("mark", "good");
        }
        else{
          setcookie("mark","bad");
        } 
        session_destroy();
      }
    }
    header("Location: index.php");
    exit();
  }
?>