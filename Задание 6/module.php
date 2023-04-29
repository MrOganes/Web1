<?php

function DB_link(){
    $user = 'u52879';
    $pass = '2750849';
    $conn = new PDO('mysql:host=localhost;dbname=u52879', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
    return $conn;
}

function DB_ADMINS($conn, $login){
    $sth = $conn->prepare("SELECT login, pass FROM ADMINS where login=:login");
    $sth->execute(['login'=>"$login"]);
    $result = $sth->fetchAll();
    return $result;
}

function GET_ID_FORMS($conn, $id){
    $sth = $conn->prepare("SELECT id_form FROM USERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $result = $sth->fetchAll();
    return $result[0]['id_form'];
}

function DB_USERS($conn){
    $sth = $conn->prepare("SELECT id, login, id_form FROM USERS");
    $sth->execute();
    $users = $sth->fetchAll();
    return $users;
}

function DB_FORMS($conn, $id){
    $sth = $conn->prepare("SELECT name, email, year, gender, limbs, biography FROM FORMS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $data = $sth->fetchAll();
    return $data;
}

function DB_SUPER($conn, $id){
    $sth = $conn->prepare("SELECT id_superpower FROM FORMS_SUPERPOWERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $data = $sth->fetchAll();
    return $data;
}

function GET_DATA_USER($conn, $id){
    $sth = $conn->prepare("SELECT * FROM FORMS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $user = $sth->fetchAll();
    return $user;
}

function DEL_COOKIE(){
    foreach($_COOKIE as $key => $value){
        setcookie($key, '', 1000000);
    }
}

function Kol_immortality($conn){
    $sth = $conn->prepare("SELECT COUNT(id) FROM FORMS_SUPERPOWERS where id_superpower=:num");
    $sth->execute(['num'=>"1"]);
    $kol = $sth->fetchAll();
    return $kol[0]['COUNT(id)'];
}

function Kol_passing_through_walls($conn){
    $sth = $conn->prepare("SELECT COUNT(id) FROM FORMS_SUPERPOWERS where id_superpower=:num");
    $sth->execute(['num'=>"2"]);
    $kol = $sth->fetchAll();
    return $kol[0]['COUNT(id)'];    
}

function Kol_levitation($conn){
    $sth = $conn->prepare("SELECT COUNT(id) FROM FORMS_SUPERPOWERS where id_superpower=:num");
    $sth->execute(['num'=>"3"]);
    $kol = $sth->fetchAll();
    return $kol[0]['COUNT(id)'];   
}

?>