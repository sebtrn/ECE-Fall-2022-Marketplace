<?php

$host = 'localhost';
$dbname = 'marketplace';
$user = 'root';
$pass = '';

$db = null;

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE marketplace";
if ($conn->query($sql) === TRUE) {

    //La base n'existe pas on la crée et on l'initialise
    $conn->close();
    $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
    $sql = file_get_contents('marketplace.sql');
    $qr = $db->exec($sql);
    $db = null;
} else {   
    //Si la base existe déjà on ne fait rien
    $conn->close();
}

//On met en place la connexion
$db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


// pour login :
// $_SESSION
?>