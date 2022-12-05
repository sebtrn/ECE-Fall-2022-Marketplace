<?php include 'conn.php' ?>

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
                <li><a class="active" href="compte.php">Mon compte</a></li>
                <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="form-compte" class="section-p1">
        <div class="form-container">
            <div class="form-btn">
                <span onclick="login()">Login</span>
                <span onclick="register()">Register</span>
                <hr id="Indicator">
            </div>
            <form id="RegForm" method="post">
                <input type="text" name="identifiant" placeholder="identifiant">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="password" placeholder="mot de passe">
                <input type="text" name="Nom" placeholder="Nom">
                <input type="text" name="Prenom" placeholder="Prenom">
                <input type="text" name="Adresse" placeholder="Adresse">
                <input type="text" name="Ville" placeholder="Ville">
                <input type="text" name="Pays" placeholder="Pays">
                <input type="number" name="CodePostal" placeholder="CodePostal">
                <input type="number" name="Telephone" placeholder="Telephone">

                <?php
                $sql = 'SELECT * FROM TypeRole WHERE IdTypeRole != 1';
                $req = $db->prepare($sql);
                $req->execute();
                $result = $req->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <select name="TypeRole">
                    <option value="">--Choisis ton rôle--</option>
                    <?php
                    foreach ($result as $row) { ?>
                        <option value="<?php echo $row['IdTypeRole']; ?>"><?php echo $row['TypeRole']; ?></option>
                    <?php
                    } ?>
                </select>
                <button type="submit" name="btn-register" class="btn" onclick="verifRegister()">Register</button>
            </form>
            <form id="LoginForm" method="post">
                <input type="text" name="identifiant" placeholder="identifiant">
                <input type="password" name="password" placeholder="mot de passe">
                <button type="submit" name="btn-login" class="btn" onclick="verifLogin()">Login</button>
            </form>
        </div>
    </section>

    <?php
    //     
    if (isset($_POST['btn-register'])) {
        if ($_POST["email"] != '' && $_POST["identifiant"] != '' && $_POST["password"] != '' && $_POST["Nom"] != '' && $_POST["Prenom"] != '' && $_POST["Adresse"] != '' && $_POST["Ville"] != '' && $_POST["Pays"] != '' && $_POST["CodePostal"] != '' && $_POST["Telephone"] != '' && $_POST["TypeRole"] != '') {
            // $sql = 'INSERT INTO utilisateur (`Pseudo`, `Email`, `Password`, `Prenom`, `Nom`, `Adresse`, `Ville`, `Pays`, `CodePostal`, `Telephone`, `IdTypeRole`) VALUES (:identifiant, :email, `:password`, :Prenom, :Nom, :Adresse, :Ville, :Pays,:CodePostal, :Telephone, :TypeRole)';

            $sql = 'INSERT INTO utilisateur SET Pseudo = :Pseudo, Email = :Email, Password = :Password, Prenom = :Prenom, Nom = :Nom, Adresse = :Adresse, Ville = :Ville, Pays = :Pays, CodePostal = :CodePostal, Telephone = :Telephone, IdTypeRole = :IdTypeRole';

            $req = $db->prepare($sql);
            $req->execute(array(
                ':Pseudo' => ($_POST["identifiant"]),
                ':Email' => ($_POST["email"]),
                ':Password' => ($_POST["password"]),
                ':Prenom' => ($_POST["Prenom"]),
                ':Nom' => ($_POST["Nom"]),
                ':Adresse' => ($_POST["Adresse"]),
                ':Ville' => ($_POST["Ville"]),
                ':Pays' => ($_POST["Pays"]),
                ':CodePostal' => (intval($_POST["CodePostal"])),
                ':Telephone' => (intval($_POST["Telephone"])),
                ':IdTypeRole' => (intval($_POST["TypeRole"]))
            ));

            session_start();
            $_SESSION['IdUtilisateur'] = $db->lastInsertId();
            $_SESSION['Pseudo'] = $_POST["identifiant"];
        } else {
            echo "<script>alert(\"Un champ est vide\")</script>";
        }
    }

    if (isset($_POST['btn-login'])) {
        if ($_POST["identifiant"] != '' && $_POST["password"] != '') {
            //commencer le query
            $sql = "SELECT * FROM utilisateur u WHERE u.Pseudo = :Pseudo AND u.Password = :Password";
            $req = $db->prepare($sql);
            $req->execute(array(
                ':Pseudo' => ($_POST["identifiant"]),
                ':Password' => ($_POST["password"])
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)>0)
            {
                session_start();
                $_SESSION['IdUtilisateur'] = $result[0]['IdUtilisateur'];
                $_SESSION['Pseudo'] = $result[0]['Pseudo'];
            }
        }
    }
    ?>

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