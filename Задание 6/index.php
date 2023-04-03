<?php
header('Content-Type: text/html; charset=UTF-8');
include('module.php');
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
  if(!empty($_GET['but'])){
    DEL_COOKIE();
    $conn = DB_link();
    $user = GET_DATA_USER($conn, $_GET['but']);
    $result = DB_FORMS($conn, $user[0]['id_form']);
    setcookie('id_form', $user[0]['id_form']);
    setcookie('id_super', $user[0]['id_superpowers']);

    setcookie("name", $result[0]['name']);
    setcookie("email", $result[0]["email"]);
    setcookie("year", $result[0]["year"]);
    setcookie("gender", $result[0]["gender"]);
    setcookie("kol", $result[0]["limbs"]);
    setcookie("biography", $result[0]["biography"]);

    $result_super =  DB_SUPER($conn, $user[0]['id_superpowers']);
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

      
      $conn = DB_link();
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
    }
    header("Location: index.php");
    exit();
  }
?>