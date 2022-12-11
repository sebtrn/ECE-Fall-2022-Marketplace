<!--Connexion BDD-->

<?php

$host = 'localhost';
$dbname = 'marketplace';
$user = 'root';
$pass = '';

$db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass,
array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// pour login :
// $_SESSION
?>