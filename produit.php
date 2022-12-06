<?php
include 'conn.php';
session_start();
$bArticleAdded = false;
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

// var_dump($_SESSION['IdUtilisateur']);
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
                <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
            </ul>
        </div>
    </section>
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="<?php echo $result['Img']; ?>" width="100%" id="MainImg" alt="">

        </div>
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
    </section>
    <section id="produit1" class="section-p1">
        <h2>Recommandations</h2>
        <p>Collection Hiver/Printemps</p>
        <div class="pro-container">
            <?php
            $sql = 'SELECT * FROM article a WHERE a.IdArticle != :IdArticle ORDER BY a.DateCreation LIMIT 4';
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
    <script>
        var MainImg = document.getElementById("MainImg");
        var smallimg = document.getElementsByClassName("small-img");
        smallimg[0].onclick = function() {
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function() {
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function() {
            MainImg.src = smallimg[2].src;
        }
        smallimg[3].onclick = function() {
            MainImg.src = smallimg[3].src;
        }
    </script>
    <script src="script.js"></script>
</body>

</html>