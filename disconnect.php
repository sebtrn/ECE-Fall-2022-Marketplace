<?php Session_start();
Session_destroy();
// header('Location: index.php');
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>