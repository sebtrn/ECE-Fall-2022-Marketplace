<?php include 'conn.php';
session_start();?>

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
                <li><a class="active" href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
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
    <section id="hero">
        <h4>FASHION CLOTHES</h4>
        <h2>What you need is here</h2>
        <h1>OMNES Marketplace</h1>
        <br>
        <button>Shop Now</button>
    </section>
    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="">
            <h6>100% en ligne</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="">
            <h6>Livraison express</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="">
            <h6>24/7 Support</h6>
        </div>
    </section>
    <section id="produit1" class="section-p1">
        <h2>Best-sellers</h2>
        <p>Collection Hiver - Printemps</p>
        <div class="pro-container">

        <?php

        // Lister tous les articles
        $sql = 'SELECT * FROM article a WHERE a.QuantiteMax > 0 ORDER BY a.DateCreation DESC';
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row)
        {
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
    </section>
    <section id="banner" class="section-m1">
        <h2>Black Friday</h2>
        <h4>Jusqu'à <span>60% Off</span> sur une sélection d'articles</h4>
        <button class="normal">Découvrir</button>
    </section>
    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Offres du moment</h4>
            <h2>Les classiques</h2>
            <span>Produits minutieusement choisis par l'équipe</span>
            <button class="white">Découvrir</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>T-Shirt et Pull</h4>
            <h2>Parfait pour l'hiver</h2>
            <span>Qu'attendez vous</span>
            <button class="white">Découvrir</button>
        </div>
    </section>
    <section id="banner3">
        <div class="banner-box">
            <h2>BLACKFRIDAY</h2>
            <h3>Du 01/12 au 31/12</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>Nouvelles Sneakers</h2>
            <h3>Style décontracté</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>Etudiant ECE</h2>
            <h3>-20% OFF</h3>
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
            <img class="logo"src="logo_blanc.png" alt="">
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