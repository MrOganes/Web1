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
  $pattern = '/^[a-zA-Zа-яА-Я0-9,. \'"-]*$/u';
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


    $sth2 = $conn->prepare("SELECT id_superpower FROM FORMS_SUPERPOWERS where id=:id");
    $sth2->execute(['id'=>"$id"]);
    $result_super = $sth2->fetchAll();

    if(isset($_COOKIE["immortality"])){
      setcookie("immortality", "", 1000000);
    }
    if(isset($_COOKIE["passing_through_walls"])){
      setcookie("passing_through_walls", "", 1000000);
    }
    if(isset($_COOKIE["ok"])){
      setcookie("levitation", "", 1000000);
    }

    
    foreach($result_super as $cout){
      if($cout['id_superpower'] =="1"){
        setcookie("immortality","yes");
      }
      if($cout['id_superpower'] =="2"){
        setcookie("passing_through_walls","yes");
      }
      if($cout['id_superpower'] =="3"){
        setcookie("levitation","yes");
      }
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
        $flag = 0;
        $stmt = $conn->prepare("INSERT INTO FORMS(name, email, year, gender, limbs, biography) VALUES (:name, :email, :year, :gender, :limbs, :biography)");
        $rez=$stmt->execute(['name'=>"$name",'email'=>"$email", 'year'=>"$year", 'gender'=>"$gender", 'limbs'=>"$kol", 'biography'=>"$biography"]);
        if($rez != 1){
          $flag+=1;
        }
        $id_form=$conn->lastInsertId();

        if($immortality=="yes"){
          $num = 1;
          $stmt2=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
          $rez2=$stmt2->execute(['id'=>"$id_form", 'id_superpower'=>"$num"]);
          if($rez2 != 1){
            $flag+=1;
          }
        }
  
        if($passing_through_walls=="yes"){
          $num = 2;
          $stmt3=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
          $rez3=$stmt3->execute(['id'=>"$id_form", 'id_superpower'=>"$num"]);
          if($rez3 != 1){
            $flag+=1;
          }
        }
        if($levitation=="yes"){
          $num = 3;
          $stmt4=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
          $rez4=$stmt4->execute(['id'=>"$id_form", 'id_superpower'=>"$num"]);
          if($rez4 != 1){
            $flag+=1;
          }
        }


        $bytes_log = openssl_random_pseudo_bytes(4);
        $bytes_pass = openssl_random_pseudo_bytes(5);
        $log = bin2hex($bytes_log);
        $pass_komb = bin2hex($bytes_pass);
        $pass = md5($pass_komb);
        $stmt5=$conn->prepare("INSERT INTO USERS(login, password, id_form) VALUES (:login, :password, :id_form)");
        $rez5=$stmt5->execute(['login'=>"$log", 'password'=>"$pass", 'id_form'=>"$id_form"]);
        if($rez5 != 1){
          $flag+=1;
        }
        setcookie("login_new",$log);
        setcookie("password_new", $pass_komb);
        if($flag==0){
          setcookie("mark", "good");
        }
        else{
          setcookie("mark","bad");
        }  
      }
      else{
          $flag = 0;
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
          if($rez5 == 0){
            $flag+=1;
          }
        
          $stmt6 = $conn->prepare("DELETE FROM FORMS_SUPERPOWERS WHERE id = :id");
          $stmt6->bindValue("id",$_COOKIE['id_form']);
          $rez6 = $stmt6->execute();
          if($rez6 == 0){
            $flag+=1;
          }
          $id = $_COOKIE['id_form'];


          if($immortality=="yes"){
            $num = 1;
            $stmt2=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
            $rez2=$stmt2->execute(['id'=>"$id", 'id_superpower'=>"$num"]);
            if($rez2 != 1){
              $flag+=1;
            }
          }
    
          if($passing_through_walls=="yes"){
            $num = 2;
            $stmt3=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
            $rez3=$stmt3->execute(['id'=>"$id", 'id_superpower'=>"$num"]);
            if($rez3 != 1){
              $flag+=1;
            }
          }
          if($levitation=="yes"){
            $num = 3;
            $stmt4=$conn->prepare("INSERT INTO FORMS_SUPERPOWERS(id, id_superpower) VALUES (:id, :id_superpower)");
            $rez4=$stmt4->execute(['id'=>"$id", 'id_superpower'=>"$num"]);
            if($rez4 != 1){
              $flag+=1;
            }
          }

        if($flag==0){
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
