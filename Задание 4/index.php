<?php
header('Content-Type: text/html; charset=UTF-8');
$rez="";


function Test_name($data){
  $pattern = '/^[а-яёЁА-Я]+$/u';
  if(preg_match($pattern, $data)){
    return 1;
  }
  else{
    return 0;
  }
}

function Test_email($data){
  $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
  if(preg_match($pattern, $data)){
    return 1;
  }
  else{
    return 0;
  }
}

function Test_biography($data){
  $pattern = '/^[a-zA-Zа-яА-Я\s.,!?-]{1,255}$/u';
  if(preg_match($pattern, $data)){
    return 1;
  }
  else{
    return 0;
  }
}


if($_SERVER["REQUEST_METHOD"] == "GET"){
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
      if(Test_name($_POST["name"])){
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
      if(Test_email($_POST["email"])){
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
      if(Test_biography($_POST["biography"])){
        setcookie("biographyErr","",1000000);
        setcookie("biography",$_POST["biography"]);
      }
      else{
        $error=TRUE;
        setcookie("biographyErr","При заполнении биографии доступны только символы а-я, a-z и знаки препинания.");
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
      foreach($superpowers as $cout){
        if($cout =="бессмертие"){
          setcookie("immortality","yes", time()+60*60*24*365);
        }
        if($cout =="прохождение сквозь стены"){
          setcookie("passing_through_walls","yes", time()+60*60*24*365);
        }
        if($cout =="левитация"){
          setcookie("levitation","yes", time()+60*60*24*365);
        }
      }
      setcookie("biography",$_POST["biography"], time()+60*60*24*365);
      $immortality='no';
      $passing_through_walls='no';
      $levitation='no';
      foreach($superpowers as $cout){
        if($cout =="бессмертие"){
          $immortality="yes";
        }
        if($cout =="прохождение сквозь стены"){
          $passing_through_walls="yes";
        }
        if($cout =="левитация"){
          $levitation="yes";
        }
      }

      $name = $_POST["name"];
      $email = $_POST["email"];
      $year = $_POST["year"];
      $gender = $_POST["pol"];
      $kol = $_POST["kol"];
      $biography=$_POST["biography"];
      
      $flag = 0;
      $user = 'u52879';
      $pass = '2750849';
      $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
      $stmt = $conn->prepare("INSERT INTO FORMS(name, email, year, gender, limbs, biography) VALUES (:name, :email, :year, :gender, :limbs, :biography)");
      $rez=$stmt->execute(['name'=>"$name",'email'=>"$email", 'year'=>"$year", 'gender'=>"$gender", 'limbs'=>"$kol", 'biography'=>"$biography"]);
      $id_form=$conn->lastInsertId();
      if($rez != 1){
        $flag+=1;
      }


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

      if($flag==0){
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
