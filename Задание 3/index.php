<?php
header('Content-Type: text/html; charset=UTF-8');
$nameErr = $emailErr = $genderErr = $kolErr = $superpowersErr = $biographyErr = $okErr = "";
$name = $email = $year = $gender = $kol  = $biography = $ok = "";
$rez="";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    include('form.php');
    exit();
}
else{
    $error="";
    $flag = 0;
    if (empty(test_input($_POST["name"]))) {
      $nameErr = "Введите имя!";
      $flag++;
    } else {
      $name = test_input($_POST["name"]);
    }
  
    if(empty(test_input($_POST["email"]))){
      $emailErr="Введите emal!";
      $flag++;
    }
    else{
      $email = test_input($_POST["email"]);
    }
  
    $year=$_POST["year"];
  
    if(empty($_POST["pol"])){
      $genderErr="Укажите пол!";
      $flag++;
    }
    else{
      if($_POST["pol"]=="Мужской"){
        $gender="Мужской";
      }
      else{
        $gender="Женский";
      }
    }
  
    if(empty($_POST["kol"])){
      $kolErr="Укажите кол-во конечностей!";
      $flag++;
    }
    else{
      if($_POST["kol"]=="2"){
        $kol="2";
      }
      else if($_POST["kol"]=="4"){
        $kol="4";
      }
      else{
        $kol="6";
      }
    }
  
    if(empty($_POST["superpowers"])){
      $superpowersErr="Укажите сверхспособности!";
      $flag++;
    }
    else{
      $superpowers=$_POST["superpowers"];
    }
  
    if(empty(test_input($_POST["biography"]))){
      $biographyErr="Заполните биографию!";
      $flag++;
    }
    else{
      $biography=$_POST["biography"];
    }
  
    if(empty($_POST["ok"])){
      $okErr="Примите правила компании!";
    }
    
    if($flag>0){
      $error="Заполните выделенные поля";
      if(!empty($okErr)){
        $error=$error." и примите правила компании!";
      }
      else{
        $error=$error."!";
      }
    }else if(!empty($okErr)){
      $error="Примите правила компании!";
    }
  
    if(empty($error)){
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
  
      $user = 'u52879';
      $pass = '2750849';
      $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
      $stmt = $conn->prepare("INSERT INTO FORMS(name, email, year, gender, limbs, biography) VALUES (:name, :email, :year, :gender, :limbs, :biography)");
      $rez=$stmt->execute(['name'=>"$name",'email'=>"$email", 'year'=>"$year", 'gender'=>"$gender", 'limbs'=>"$kol", 'biography'=>"$biography"]);
      $id_form=$conn->lastInsertId();
      $stmt2=$conn->prepare("INSERT INTO SUPERPOWERS(immortality, passing_through_walls,levitation) VALUES (:immortality, :passing_through_walls, :levitation)");
      $rez2=$stmt2->execute(['immortality'=>"$immortality", 'passing_through_walls'=>"$passing_through_walls", 'levitation'=>"$levitation"]);
      $id_super=$conn->lastInsertId();
      $stmt3=$conn->prepare("INSERT INTO FORM_SUPERPOWER(id_DATA_FORM, id_DATA_superpower) VALUES (:id_DATA_FORM, :id_DATA_superpower)");
      $rez3=$stmt3->execute(['id_DATA_FORM'=>"$id_form", 'id_DATA_superpower'=>"$id_super"]);
    
      if($rez==1 && $rez2==1 && $rez3==1){
        $rez=1;
      }
      else{
        $rez=0;
      }
  
      $name = $email = $year = $gender = $kol  = $biography = $ok = "";
      $superpowers=array();
    }
    include('form.php');
  }
?>