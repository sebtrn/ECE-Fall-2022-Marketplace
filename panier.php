<?php
include 'conn.php';
// header
session_start();

if(isset($_GET['IdPanier'])){
    header('Location: panier.php');
    $sql = 'DELETE FROM panier WHERE IdPanier = :IdPanier';
    $req = $db->prepare($sql);
    $req->execute(array(
        ':IdPanier' => intval($_GET["IdPanier"])
    ));
}
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
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="notification.php">Notification</a></li>
                <li><a href="compte.php">Mon compte</a></li>
                <?php if (isset($_SESSION['IdUtilisateur'])) { ?>
                <li><a class="active" href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li><a href="disconnect.php"><i class="fa-solid fa-power-off"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <section id="page-header" class="about-header ">
        <h2>#OMNES MarketPlace</h2>
        <p>Votre panier</p>
    </section>



    <section id="panier" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Supprimer</td>
                    <td>Image</td>
                    <td>Produit</td>
                    <td>Prix</td>
                    <td>Quantite</td>
                </tr>
            <tbody>

                <?php

                $sql = 'SELECT * FROM panier p LEFT join article a ON p.IdArticle = a.IdArticle WHERE p.IdUtilisateur = :IdUtilisateur';
                $req = $db->prepare($sql);
                $req->execute(array(
                    ':IdUtilisateur' => intval($_SESSION["IdUtilisateur"]),
                ));
                $result = $req->fetchAll(PDO::FETCH_ASSOC);

                

                foreach($result as $row) {
                ?>
                    <tr>
                        <td><a href="panier.php?IdPanier=<?php echo $row['IdPanier']?>"><i class="fa-sharp fa-solid fa-trash"></i></a></td>
                        <td><a href="produit.php?IdArticle=<?php echo $row['IdArticle']; ?>"><img src="<?php echo $row['Img']; ?>" alt=""></a></td>
                        <td><?php echo $row['NomArticle']; ?></td>
                        <td><?php echo $row['Prix']; ?>€</td>
                        <td><?php echo $row['Quantite']; ?></td>
                    </tr>
                <?php
                } ?>
            </tbody>
            </thead>
        </table>
    </section>
    <section id="panier-bottom" class="section-p1">
        <div id="coupon">
            <h3>Code promo</h3>
            <div>
                <input type="text" placeholder="Saisir votre coupon">
                <button class="normal">Appliquer</button>
            </div>
        </div>
        <?php $sql = 'SELECT SUM(a.Prix*p.Quantite) AS PrixTotal FROM panier p LEFT join article a ON p.IdArticle = a.IdArticle WHERE p.IdUtilisateur = :IdUtilisateur';
                $req = $db->prepare($sql);
                $req->execute(array(
                    ':IdUtilisateur' => intval($_SESSION["IdUtilisateur"]),
                ));
                $result = $req->fetchAll(PDO::FETCH_ASSOC);
        
                ?>
        <div id="subtotal">
        
            <h3>Total</h3>
            <table>
                <tr>
                    <td>Total</td>

                    <td><?php echo $result[0]['PrixTotal']; ?>€</td>
                </tr>
                <tr>
                    <td>Livraison</td>
                    <td>Gratuit</td>
                </tr>
                <tr>
                    <td><strong>Total commande</strong></td>
                    <td><strong><?php echo $result[0]['PrixTotal']; ?>€</strong></td>
                </tr>
            </table>
            <a href="paiement.php"><button class="normal">Paiement</button></a>
            
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