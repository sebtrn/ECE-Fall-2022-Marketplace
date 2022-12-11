<?php
include 'conn.php';
session_start();
<<<<<<< HEAD
//Booléen si l'utilisateur n'est pas connecté reste à false et ne peut pas ajouter d'article
$bArticleAdded = false;
//Lorsqu'on appuie sur le bouton addArticle, on ajoute au panier de l'utilisateur connecté sur la session, l'idarticle et sa quantite
=======
checkWinner($db);
$bArticleAdded = false;
$pPriceAdded = false;
>>>>>>> f929bb8986eced553a9bba48f734518f24ccffd2
if (isset($_POST['addArticle'])) {
    if (isset($_SESSION['IdUtilisateur'])) {
        $sql = 'INSERT INTO panier SET IdArticle = :IdArticle, IdUtilisateur = :IdUtilisateur, Quantite = :Quantite';
        $req = $db->prepare($sql);
        $req->execute(array(
            ':IdArticle' => intval($_GET["IdArticle"]),
            ':IdUtilisateur' => intval($_SESSION["IdUtilisateur"]),
            ':Quantite' => intval($_POST['Quantite'])
        ));
        $bArticleAdded = true;
    } else {
        header('Location: compte.php');
    }
}
else if (isset($_POST['addEnchere'])) {
    if (isset($_SESSION['IdUtilisateur'])) {

        $sql = 'SELECT * FROM article a WHERE a.IdArticle = :IdArticle';
        $req = $db->prepare($sql);

        $req->execute(array(':IdArticle' => intval($_GET["IdArticle"])));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $result = $result[0];


        $sql = 'DELETE FROM article WHERE IdUtilisateur=:IdUtilisateur AND PrixNegociation IS NOT NULL';
        $req = $db->prepare($sql);

        $req->execute(array(':IdUtilisateur' => intval($_SESSION['IdUtilisateur'])));

        $sql = 'INSERT INTO article SET IdUtilisateur = :IdUtilisateur, NomArticle = :NomArticle, 
        Marque = :Marque, Img = :Img, QuantiteMax = :QuantiteMax, Prix = :Prix, IdTypeArticle = :IdTypeArticle, 
        IdTypeVente = :IdTypeVente, PrixNegociation = :PrixNegociation,
        Description = :Description';
                    $req = $db->prepare($sql);
                    $req->execute(array(
                        ':IdUtilisateur' => ($_SESSION['IdUtilisateur']),
                        ':NomArticle' => ($result["NomArticle"]),
                        ':Marque' => ($result["Marque"]),
                        ':Img' => ($result["Img"]),
                        ':QuantiteMax' => (intval("1")),
                        ':Prix' => (floatval($result["Prix"])),
                        ':IdTypeArticle' => (intval($result["IdTypeArticle"])),
                        ':IdTypeVente' => (intval("3")),
                        ':PrixNegociation' => (floatval($_POST["PrixEnchere"])),
                        ':Description' => ($result["Description"])
                    ));
        //$sql = 'INSERT INTO panier SET IdArticle = :IdArticle, IdUtilisateur = :IdUtilisateur, Quantite = :Quantite';
        if((floatval($_POST["PrixEnchere"]) > $result["Prix"]))
        {

            $sql = 'UPDATE article SET IdUtilisateur=:IdUtilisateur, Prix=:Prix WHERE IdArticle=:IdArticle';
            $req = $db->prepare($sql);
    
            $req->execute(array(':IdUtilisateur'=> ($_SESSION['IdUtilisateur']),':Prix' => intval($_POST["PrixEnchere"]),
                                ':IdArticle' => intval($_GET['IdArticle'])
                            ));
        }
        

        $pPriceAdded = true;
        checkWinner($db);
    } else {
        header('Location: compte.php');
    }
}

function checkWinner($db)
{

    $old_date = date('l, F d y h:i:s');              
    $old_date_timestamp = strtotime($old_date);
    $timezone = date("Y-m-d H:i:s", strtotime('+13 hours', $old_date_timestamp));

    echo $timezone;


    $sql = 'SELECT * FROM article WHERE IdTypeVente = 3 AND PrixNegociation IS NULL';

    $req = $db->prepare($sql);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);

    for($i = 0; $i < count($result); $i++)
    {

        echo $result[$i]["DateExpBestOffer"];
        echo "<br>";

        if(!($timezone >= $result[$i]["DateExpBestOffer"]))
            return;

        $sql = 'SELECT * FROM article WHERE IdUtilisateur=:IdUtilisateur';
        $req = $db->prepare($sql);
        $req->execute(array(':IdUtilisateur' => $result[$i]['IdUtilisateur']));

        $yeet = $req->fetchAll(PDO::FETCH_ASSOC);
    
        if($yeet != null)
        {
            $yeet = $yeet[0];
            $sql = 'INSERT INTO panier SET IdArticle = :IdArticle, IdUtilisateur = :IdUtilisateur, Quantite = :Quantite';
            $req = $db->prepare($sql);
            $req->execute(array(
                ':IdArticle' => intval($result[$i]["IdArticle"]),
                ':IdUtilisateur' => intval($yeet["IdUtilisateur"]),
                ':Quantite' => intval("1")
            ));

            $sql = 'DELETE FROM article WHERE PrixNegociation IS NOT NULL AND NomArticle=:NomArticle';
            $req = $db->prepare($sql);
            $req->execute(array(':NomArticle' => intval($result[$i]['NomArticle'])));
            //echo "Ajouter";
            $bArticleAdded = true;
            break;
        }
    }
}

// var_dump($_SESSION['IdUtilisateur']);
//On liste les articles dont l'idarticle match celui ajouté
$sql = 'SELECT * FROM article a WHERE a.IdArticle = :IdArticle';
$req = $db->prepare($sql);
$req->execute(array(
    ':IdArticle' => intval($_GET["IdArticle"])
));
$result = $req->fetchAll(PDO::FETCH_ASSOC);
$result = $result[0];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMNES MarketPlace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section id="header">
        <a href="#"><img src="img/logo.png" alt="" width="172px" height="70px"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Accueil</a></li>
                <li><a class="active" href="shop.php">Boutique</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="notification.php">Notification</a></li>
                <li><a href="compte.php">Mon compte</a></li>
                <?php if (isset($_SESSION['IdUtilisateur'])) { ?>
                    <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                    <li><a href="disconnect.php"><i class="fa-solid fa-power-off"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="<?php echo $result['Img']; ?>" width="100%" id="MainImg" alt="">

        </div>
<<<<<<< HEAD
        <div class="single-pro-details">
            <h6><a href="index.php">Accueil</a>>Pull</h6>
            <h4><?php echo $result['NomArticle']; ?></h4>
            <h2><?php echo $result['Prix']; ?>€</h2>
            <select>
                <option>Taille</option>
                <option>S</option>
                <option>M</option>
                <option>L</option>
                <option>XL</option>
            </select>
            <form action="" method="post">
                <input type="number" name="Quantite" value="1" min="1" max="<?php echo $result['QuantiteMax']; ?>">
                <button type="submit" name="addArticle" class="normal">Ajouter Au Panier</button>
                <?php if ($bArticleAdded) {
                    echo "Article ajouté au panier";
                } ?>
            </form>
            <h4>Description</h4>
            <span><?php echo $result['Description']; ?></span>
        </div>
=======

            <?php
            if($result["IdTypeVente"] == 3)
            {?>
                <div class="single-pro-details">
                <h6><a href="index.php">Accueil</a>>Pull</h6>
                <h4><?php echo $result['NomArticle']; ?></h4>
                <h2><?php echo "Prix d'enchère actuelle: ".$result['Prix']; ?>€</h2>
                <form action="" method="post">
                <input type="number" name="PrixEnchere" min="<?php $result['Prix'] ?>">
                    <button type="submit" name="addEnchere" class="normal">Enchérir</button>
                    <?php if ($pPriceAdded) {
                        echo "Votre prix d'achat a été ajouté !";
                    }
                    else if($bArticleAdded){
                        echo "Vous avez gagné la vente aux enchères votre article est maintenant dans votre panier !";
                    }
                    ?>
                </form>
                <h4>Description</h4>
                <span><?php echo $result['Description']; ?></span>
                <?php
                
                $sql = 'SELECT * FROM article a WHERE a.IdArticle = :IdArticle';
                $req = $db->prepare($sql);
                $req->execute(array(':IdArticle' => intval($_GET["IdArticle"])));
                $result = $req->fetchAll(PDO::FETCH_ASSOC);
                $result = $result[0];

                $sql = 'SELECT DISTINCT* FROM utilisateur,article WHERE article.IdUtilisateur=utilisateur.IdUtilisateur 
                AND 
                article.NomArticle = :NomArticle 
                AND PrixNegociation IS NOT NULL';

                $req = $db->prepare($sql);
                $req->execute(array(':NomArticle' => $result['NomArticle']));

                $result = $req->fetchAll(PDO::FETCH_ASSOC);
                
                    echo "<table border=\"1\">";
                    echo "<tr>";
                    echo "<th>" . "Nom" . "</th>";
                    echo "<th>" . "Prénom" . "</th>";
                    echo "<th>" . "Prix d'enchère client" . "</th>";
                    echo "</tr>";

                    for ($i = 0 ; $i < count($result); $i++) {
                        echo "<tr>";
                        echo "<td>" . $result[$i]['Nom'] . "</td>";
                        echo "<td>" . $result[$i]['Prenom'] . "</td>";
                        echo "<td>" . $result[$i]['PrixNegociation'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <?php

            }
            else if($result["IdTypeVente"] == 1)
            {
                ?>
                <div class="single-pro-details">
                <h6><a href="index.php">Accueil</a>>Pull</h6>
                <h4><?php echo $result['NomArticle']; ?></h4>
                <h2><?php echo $result['Prix']; ?>€</h2>
                <select>
                    <option>Taille</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                </select>
                <form action="" method="post">
                    <input type="number" name="Quantite" value="1" min="1" max="<?php echo $result['QuantiteMax']; ?>">
                    <button type="submit" name="addArticle" class="normal">Ajouter Au Panier</button>
                    <?php if ($bArticleAdded) {
                        echo "Article ajouté au panier";
                    }?>
                </form>
                <h4>Description</h4>
                <span><?php echo $result['Description']; ?></span>
                </div>
                <?php
            }?>
>>>>>>> f929bb8986eced553a9bba48f734518f24ccffd2
    </section>
    <section id="produit1" class="section-p1">
        <h2>Recommandations</h2>
        <p>Collection Hiver/Printemps</p>
        <div class="pro-container">
            <?php
            $sql = 'SELECT * FROM article a WHERE PrixNegociation IS NULL AND a.IdArticle != :IdArticle ORDER BY a.DateCreation DESC LIMIT 4';
            $req = $db->prepare($sql);
            $req->execute(array(
                ':IdArticle' => intval($_GET["IdArticle"])
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
                <div class="pro">
                    <img src="<?php echo $row['Img']; ?>" alt="">
                    <div class="description">
                        <span><?php echo $row['Marque']; ?></span>
                        <h5><?php echo $row['NomArticle']; ?></h5>
                        <div class="note">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4><?php echo $row['Prix']; ?>€</h4>
                    </div>
                    <a href="produit.php?IdArticle=<?php echo $row['IdArticle']; ?>">
                        <div class="cart"><i class="fa-solid fa-cart-shopping"></i></div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>S'inscrire à la newsletter</h4>
            <p>Recevez toutes les <span>offres exclusives.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Votre email">
            <button class="normal">S'inscrire</button>
        </div>
    </section>
    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="logo_blanc.png" alt="">
            <h4>Contact</h4>
            <p><strong>Adresse:</strong> Rue Sextius Michel, 75015 Paris</p>
            <p><strong>Téléphone:</strong>01 44 39 06 00</p>
            <p><strong>Horaires:</strong>8:00 - 19:00, Lundi-Samedi</p>
            <div class="follow">
                <h4>Suivez-nous</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>A propos</h4>
            <a href="about.php">About</a>
            <a href="#">Livraison & retours</a>
            <a href="about.php">Conditions générales</a>
            <a href="about.php">Confidentialité et cookies</a>
            <a href="about.php">Contactez-nous</a>
        </div>
        <div class="col">
            <h4>Mon compte</h4>
            <a href="compte.php">Se connecter</a>
            <a href="panier.php">Mon panier</a>
            <a href="panier.php">Ma wishlist</a>
            <a href="about.php">Assistance</a>
        </div>
        <div class="col install">
            <h4>Application mobile</h4>
            <p>Disponible sur l'App Store ou le Play Store</p>
            <div class="row">
                <img src="img/pay/app.jpg" alt="">
                <img src="img/pay/play.jpg" alt="">
            </div>
            <p>Paiement 100% sécurisé</p>
            <img src="img/pay/pay.png" alt="">
        </div>
        <div class="copyright">
            <p>©Projet Web dynamique 2022 - OMNES Marketplace Groupe 971</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>