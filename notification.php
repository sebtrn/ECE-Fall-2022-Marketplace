<?php include 'conn.php';
session_start(); ?>


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
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="notification.php">Notification</a></li>
                <li><a href="compte.php">Mon compte</a></li>
                <?php if (isset($_SESSION['IdUtilisateur'])) { ?>
                    <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                    <li><a href="disconnect.php"><i class="fa-solid fa-power-off"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <section id="form-recherche">
        <form method="post">
            <input type="number" name="min" min="1" placeholder="Prix Min">
            <input type="number" name="max" min="1" placeholder="Prix Max">
            <select name="IdTypeArticle">
                <option value="">Selectionner un article</option>
                <?php
                $sql = 'SELECT * FROM typearticle';
                $req = $db->prepare($sql);
                $req->execute();
                $result = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                ?>
                    <option value="<?php echo $row['IdTypeArticle'] ?>"><?php echo $row['TypeArticle'] ?></option>
                <?php } ?>
            </select>
            <button name="rechercheArticle" type="submit" class="normal">Rechercher</button>
        </form>
    </section>
    <?php

    if (isset($_POST['rechercheArticle'])) {
        if($_POST['min'] != "" && $_POST['max'] != "" && $_POST['min'] > $_POST['max'] ){
            echo '<script>alert("Parametre invalide")</script>';
        }
        $params = [];
        if ($_POST['min'] != "") {
            $reqMin = ' AND a.Prix >= ' . $_POST['min'];
            array_push($params, $reqMin);
        }
        if ($_POST['max'] != "") {
            $reqMax = ' AND a.Prix <= ' . $_POST['max'];
            array_push($params, $reqMax);
        }

        if ($_POST['IdTypeArticle'] != "") {
            $reqIdTypeArticle = ' AND a.IdTypeArticle = ' . $_POST['IdTypeArticle'];
            array_push($params, $reqIdTypeArticle);
        }

        $sql = 'SELECT * from article a WHERE a.QuantiteMax > 0';
        foreach ($params as $row) {
            $sql .= $row;
        }
        $req = $db->prepare($sql);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

    ?>

        <section id="produit1" class="section-p1">
            <div class="pro-container">
                <?php

                foreach ($result as $row) {
                ?>
                    <div class="pro">
                        <img src="<?php echo $row['Img']; ?>" alt="">
                        <div class="description">
                            <span><?php echo $row['Marque']; ?></span>
                            <h5> <?php echo $row['NomArticle']; ?> </h5>
                            <div class="note">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4><?php echo $row['Prix']; ?>€ </h4>
                        </div>
                        <a href="produit.php?IdArticle=<?php echo $row['IdArticle']; ?>">
                            <div class="cart"><i class="fa-solid fa-cart-shopping"></i></div>
                        </a>
                    </div>

                <?php
                }

                ?>
            </div>
        </section>
    <?php } ?>
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
            <h4>About</h4>
            <a href="#">About</a>
            <a href="#">Livraison & retours</a>
            <a href="#">Conditions générales</a>
            <a href="#">Confidentialité et cookies</a>
            <a href="#">Contactez-nous</a>
        </div>
        <div class="col">
            <h4>Mon compte</h4>
            <a href="#">Se connecter</a>
            <a href="#">Mon panier</a>
            <a href="#">Ma wishlist</a>
            <a href="#">Suivi de commande</a>
            <a href="#">Assistance</a>
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