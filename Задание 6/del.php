<?php
include('module.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['but'];
    $conn=DB_link();
    $sth = $conn->prepare("SELECT id_form FROM USERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $user = $sth->fetchAll();
    $id_form = $user[0]['id_form'];

    $sth = $conn->prepare("DELETE FROM USERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $sth = $conn->prepare("DELETE FROM FORMS where id=:id");
    $sth->execute(['id'=>"$id_form"]);
    $sth = $conn->prepare("DELETE FROM FORMS_SUPERPOWERS where id=:id");
    $sth->execute(['id'=>"$id_form"]);
}
header("Location: admin.php");
exit();
?>