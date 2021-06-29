<?php

session_start();

$id = 0;
$name = '';
$achternaam = '';
$datum = '';
$update = false;

//verbind met database
//ophalen van variabelen en invoegen in database
$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(msqli_error($mysqli));

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $datum = $_POST['datum'];

  $mysqli->query("INSERT INTO data (voornaam , achternaam , geboortedatum) VALUES('$name', '$lastname', '$datum')")
    or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved!";
  $_SESSION['msg_type'] = "success";

  header("location: index.php");
}
//verwijderen van gegevens
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location: index.php");
}
//het updaten van de gegevens
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
  if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_array();
    $name = $row['voornaam'];
    $achternaam = $row['achternaam'];
    $datum = $row['geboortedatum'];
  }
}
//het ophalen van de nieuwe gegevens en die naar de database sturen
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $date = $_POST['datum'];
  echo $date;
  echo $name;
  echo $lastname;
  echo $id;
  $mysqli->query("UPDATE data SET voornaam='$name', achternaam='$lastname' , geboortedatum='$date' WHERE id=$id;")
    or die($mysqli->error);

  $_SESSION['message'] = "Record has been updated!";
  $_SESSION['msg_type'] = "warning";

  header('location: index.php');
}
