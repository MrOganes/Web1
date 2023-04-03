<?php
include('module.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['but'];
    $conn=DB_link();
    $sth = $conn->prepare("SELECT id_form, id_superpowers FROM USERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $user = $sth->fetchAll();
    $id_form = $user[0]['id_form'];
    $id_superpowers = $user[0]['id_superpowers'];

    $sth = $conn->prepare("DELETE FROM USERS where id=:id");
    $sth->execute(['id'=>"$id"]);
    $sth = $conn->prepare("DELETE FROM FORMS where id=:id");
    $sth->execute(['id'=>"$id_form"]);
    $sth = $conn->prepare("DELETE FROM SUPERPOWERS where KEY_DATA =:KEY_DATA ");
    $sth->execute(['KEY_DATA'=>"$id_superpowers"]);
    $sth = $conn->prepare("DELETE FROM FORM_SUPERPOWER where id_DATA_FORM=:id_DATA_FORM and id_DATA_superpower=:id_DATA_superpower");
    $sth->execute(['id_DATA_FORM'=>"$id_form", 'id_DATA_superpower'=>"$id_superpowers"]);
}
header("Location: admin.php");
exit();
?>