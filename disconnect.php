<?php Session_start();
Session_destroy();
// header('Location: compte.php');
$lasturl = $_SERVER['HTTP_REFERER'];
if(strpos( $lasturl, 'panier.php')){
    header('Location: index.php');
}
else {
    header('Location: ' . $lasturl);
}


?>