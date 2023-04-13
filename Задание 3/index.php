<?php
header('Content-Type: text/html; charset=UTF-8');
$name = $email = $year = $gender = $kol  = $biography = $ok = "";
$immortality='no';
$passing_through_walls='no';
$levitation='no';
$rez="";

$error = [];

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

function Test_year($data){
  $pattern = '/^[1-9][0-9]*$/';
  if(preg_match($pattern, $data)){
    return 1;
  }
  else{
    return 0;
  }
}

function Test_gender($data){
  if($data=="Мужской" || $data="Женский"){
    return 1;
  }
  else{
    return 0;
  }
}

function Test_limbs($data){
  if($data="2" || $data="4" || $data="6"){
    return 1;
  }
  else{
    return 0;
  }
}

function Test_superpowers($data){
  foreach($data as $cout){
    if($cout!="бессмертие" && $cout!="прохождение сквозь стены" && $cout!="левитация"){
      return 0;
    }
  }
  return 1;
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

    if (empty($_POST["name"])) {
      $error[0] = "Введите имя!";
    } 
    else {
      $name = $_POST["name"];
      if(!Test_name($_POST["name"])){
        $error[0]="Для записи имени разрешены символы а-я.";
      }
      else{
        unset($error[0]);
      }
    }


    if (empty($_POST["email"])) {
      $error[1] = "Введите email!";
    } 
    else {
      $email = $_POST["email"];
      if(!Test_email($_POST["email"])){
        $error[1]="Недопустимый адрес email.";
      }
      else{
        unset($error[1]);
      }
    }


    if(empty($_POST["year"])){
      $error[2]="Введите год рождения!";
    }
    else{
      $year = $_POST["year"];
      if(!Test_year($_POST["year"])){
        $error[2]="Недопустимое значение в поле год рождения.";
      }
      else{
        unset($error[2]);
      }
    }

  
    if(empty($_POST["pol"])){
      $error[3]="Укажите пол!";
    }
    else{
      $gender = $_POST["pol"];
      if(!Test_gender($_POST["pol"])){
        $error[3]="Недопустимое значение при выбора пола.";
      }
      else{
        unset($error[3]);
      }
    }

  
    if(empty($_POST["kol"])){
      $error[4]="Укажите кол-во конечностей!";
    }
    else{
      $kol = $_POST["kol"];
      if(!Test_limbs($_POST["kol"])){
        $error[4]="Недопустимое значение при выбора кол-ва конечностей.";
      }
      else{
        unset($error[4]);
      }
    }

  
    if(empty($_POST["superpowers"])){
      $error[5]="Укажите сверхспособности!";
    }
    else{
      $superpowers = $_POST["superpowers"];
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
      if(!Test_superpowers($_POST["superpowers"])){
        $error[5]="Недопустимое значение при выбора сверхспособностей!";
      }
      else{
        unset($error[5]);
      }
    }
  
    if(empty($_POST["biography"])){
      $error[6]="Заполните биографию!";
    }
    else{
      $biography = $_POST["biography"];
      if(!Test_biography($_POST["biography"])){
        $error[6]="В поле биография доступны только символы кириллицы, латиницы и знаки препинания.";
      }
      else{
        unset($error[6]);
      }
    }

  
    if(empty($_POST["ok"])){
      $error[7]="Примите правила компании!";
    }
    else{
      unset($error[7]);
    }

    
    if(empty($error)){
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
        $rez=1;
      }
      else{
        $rez=0;
      }

      $name = $email = $year = $gender = $kol  = $biography = $ok = "";
      $immortality='no';
      $passing_through_walls='no';
      $levitation='no';
    }
    include('form.php');
  }
?>