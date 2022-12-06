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
                <li><a  href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="notification.php">Notification</a></li>
                <li><a href="compte.php">Mon compte</a></li>
                <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
            </ul>
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