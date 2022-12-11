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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<!--Navbar-->

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
        <a href="shop.php"><button class="normal">Shop Now</button></a>
    </section>

    <!--Carrousel TP4-->
    <section id="carrousel" class="section-p1">
        <ul>
            <li><img src="img/products/n2.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n3.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n4.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n5.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n6.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n7.jpg" height="700px" width="700px" /></li>
            <li><img src="img/products/n8.jpg" height="700px" width="700px" /></li>
        </ul>
    </section>
    <section id="produit1" class="section-p1">
        <h2>Selection du jour</h2>
        <p>Collection Hiver - Printemps</p>
        <div class="pro-container">
            <!--On liste les articles dont la quantite > 0 pour une boutique dynamique-->
            <?php

            // Lister tous les articles
            $sql = 'SELECT * FROM article a WHERE PrixNegociation IS NULL AND a.QuantiteMax > 0 ORDER BY a.DateCreation DESC';
            $req = $db->prepare($sql);
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

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
    </section>
    <section id="banner" class="section-m1">
        <h2>Black Friday</h2>
        <h4>Jusqu'à <span>60% Off</span> sur une sélection d'articles</h4>
        <button class="normal">Découvrir</button>
    </section>
    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Offres du moment</h4>
            <h2>Les Pulls</h2>
            <span>Produits minutieusement choisis par l'équipe</span>
            <a href="shop.php?IdTypeArticle=2"><button class="white">Découvrir</button></a>
        </div>
        <div class="banner-box banner-box2">
            <h4>T-Shirt</h4>
            <span>Qu'attendez vous</span>
            <a href="shop.php?IdTypeArticle=1"><button class="white">Découvrir</button></a>
        </div>
        <div class="banner-box banner-box3">
            <h4>Pantalon</h4>
            <span>Qu'attendez vous</span>
            <a href="shop.php?IdTypeArticle=3"><button class="white">Découvrir</button></a>
        </div>
        <div class="banner-box banner-box4">
            <h4>Chaussures</h4>
            <span>Qu'attendez vous</span>
            <a href="shop.php?IdTypeArticle=4"><button class="white">Découvrir</button></a>
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
    <script>
        $(document).ready(function() {
            var $carrousel = $('#carrousel'); // on cible le bloc du carrousel
            $img = $('#carrousel img'); // on cible les images contenues dans le carrousel
            indexImg = $img.length - 1; // on définit l'index du dernier élément
            i = 0; // on initialise un compteur
            $currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)
            $img.css('display', 'none'); // on cache les images
            $currentImg.css('display', 'block'); // on affiche seulement l'image courante
            //si on clique sur le bouton "Suivant"
            $('.next').click(function() { // image suivante
                i++; // on incrémente le compteur
                if (i <= indexImg) {
                    $img.css('display', 'none'); // on cache les images
                    $currentImg = $img.eq(i); // on définit la nouvelle image
                    $currentImg.css('display', 'block'); // puis on l'affiche
                } else {
                    i = indexImg;
                }
            });
            //si on clique sur le bouton "Précédent"
            $('.prev').click(function() { // image précédente
                i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
                if (i >= 0) {
                    $img.css('display', 'none');
                    $currentImg = $img.eq(i);
                    $currentImg.css('display', 'block');
                } else {
                    i = 0;
                }
            });

            function slideImg() {
                setTimeout(function() { // on utilise une fonction anonyme
                    if (i < indexImg) { // si le compteur est inférieur au dernier index
                        i++; // on l'incrémente
                    } else { // sinon, on le remet à 0 (première image)
                        i = 0;
                    }
                    $img.css('display', 'none');
                    $currentImg = $img.eq(i);
                    $currentImg.css('display', 'block');
                    slideImg(); // on oublie pas de relancer la fonction à la fin
                }, 4000); // on définit l'intervalle à 4000 millisecondes (4s)
            }
            slideImg(); // enfin, on lance la fonction une première fois
        });
    </script>
    <script src="script.js"></script>
</body>

</html>