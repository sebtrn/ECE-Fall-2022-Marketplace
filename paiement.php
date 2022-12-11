<!--Initialisation BDD-->

<?php
include 'conn.php';
session_start();
$bArticleAdded = false;
//On regarde si les informations entrées en INPUT MATCH une carte dans la BDD, table wallet
if(isset($_POST['ConfirmeCarte']) && isset($_SESSION['IdUtilisateur'])){
    if($_POST['NumeroCarte'] != '' && $_POST['Nom'] != '' && $_POST['CVV'] != '' && $_POST['month'] != '' && $_POST['year'] != ''){
        $sql = 'SELECT * FROM wallet w WHERE w.NumeroCarte = :NumeroCarte AND w.NomCarte = :Nom AND w.DateExp = :DateExp AND w.CodeSecu = :CVV';
        $req = $db->prepare($sql);
        $req->execute(array(
            ':NumeroCarte' => $_POST['NumeroCarte'],
            ':Nom' => $_POST['Nom'],
            ':DateExp' => $_POST['month'] . '/' . $_POST['year'],
            ':CVV' => intval($_POST['CVV'])
        ));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if($result[0] != null){

            // Get nom, prix et quantite des produits // Cacul permet d'eviter le surplus
            $sql = 'SELECT p.IdArticle, a.NomArticle, IF(SUM(p.Quantite) <= a.QuantiteMax, SUM(a.Prix * p.Quantite), a.Prix * a.QuantiteMax) AS Total, IF(SUM(p.Quantite) <= a.QuantiteMax, SUM(p.Quantite), a.QuantiteMax) AS QuantiteArticles FROM panier p LEFT JOIN article a on a.IdArticle = p.IdArticle WHERE p.IdUtilisateur = :IdUtilisateur GROUP BY p.IdArticle';
            $req = $db->prepare($sql);
            $req->execute(array(
            ':IdUtilisateur' => $_SESSION['IdUtilisateur']
            ));
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            $total = 0;
            foreach($res as $row){
                $total += $row['Total'];
            }

            // Get SOLDE
            $sql = 'SELECT w.Solde FROM wallet w';
            $req = $db->prepare($sql);
            $req->execute();
            $Solde = $req->fetchAll(PDO::FETCH_ASSOC);
            $Solde = $Solde[0]['Solde'];

            if($Solde - $total > 0){
                // update argent sur carte
                $sql = 'UPDATE wallet w SET w.Solde = w.Solde - :total WHERE w.NumeroCarte = :NumeroCarte';
                $req = $db->prepare($sql);
                $req->execute(array(
                    ':total' => $total,
                    ':NumeroCarte' => $_POST['NumeroCarte']
                ));
                // Update quantite article
                foreach ($res as $row) {
                    $sql = 'UPDATE article a SET a.QuantiteMax = IF(a.QuantiteMax - :QuantiteArticles >= 0, a.QuantiteMax - :QuantiteArticles, 0) WHERE a.IdArticle = :IdArticle';
                    $req = $db->prepare($sql);
                    $req->execute(array(
                        ':IdArticle' => $row['IdArticle'],
                        ':QuantiteArticles' => $row['QuantiteArticles']
                    )); 
                }

                // Update articles
                $sql = 'DELETE FROM panier WHERE IdUtilisateur = :IdUtilisateur';
                $req = $db->prepare($sql);
                $req->execute(array(
                    ':IdUtilisateur' => $_SESSION['IdUtilisateur']
                ));
                echo '<script>alert("Achat effectue avec succes")</script>';
            }
            else {
                echo '<script>alert("Solde insuffisant")</script>';
            }
        }
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
    <div class="paiement-container">

        <div class="card-container">

            <div class="front">
                <div class="image">
                    <img src="img/paiement/chip.png" alt="">
                    <img src="img/paiement/visa.png" alt="">
                </div>
                <div class="card-number-box">################</div>
                <div class="flexbox">
                    <div class="box">
                        <span>Nom</span>
                        <div class="card-holder-name">Nom complet</div>
                    </div>
                    <div class="box">
                        <span>Date Expiration</span>
                        <div class="expiration">
                            <span class="exp-month">mm</span>
                            <span class="exp-year">yy</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>CVV</span>
                    <div class="cvv-box"></div>
                    <img src="image/visa.png" alt="">
                </div>
            </div>

        </div>

        <form method="post">
            <div class="inputBox">
                <span>N°Carte</span>
                <input type="text" name="NumeroCarte" maxlength="16" class="card-number-input">
            </div>
            <div class="inputBox">
                <span>Nom</span>
                <input type="text" name="Nom" class="card-holder-input">
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span>Exp Mois</span>
                    <select name="month" id="" class="month-input">
                        <option value="month" selected disabled>month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Exp Annee</span>
                    <select name="year" id="" class="year-input">
                        <option value="year" selected disabled>year</option>
                        <option value="21">2021</option>
                        <option value="22">2022</option>
                        <option value="23">2023</option>
                        <option value="24">2024</option>
                        <option value="25">2025</option>
                        <option value="26">2026</option>
                        <option value="27">2027</option>
                        <option value="28">2028</option>
                        <option value="29">2029</option>
                        <option value="30">2030</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>CVV</span>
                    <input type="text" name="CVV" maxlength="4" class="cvv-input">
                </div>
            </div>
            <input type="submit" name="ConfirmeCarte" value="submit" class="submit-btn">
        </form>

    </div>
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