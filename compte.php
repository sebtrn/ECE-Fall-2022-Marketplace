<!--Initialisation BDD et de la session-->

<?php
include 'conn.php';
session_start();
//Register: post les input dans la BDD, quand on appuie sur le bouton btn-register INSERT INTO VALUES
if (isset($_POST['btn-register'])) {
    if ($_POST["email"] != '' && $_POST["identifiant"] != '' && $_POST["password"] != '' && $_POST["Nom"] != '' && $_POST["Prenom"] != '' && $_POST["Adresse"] != '' && $_POST["Ville"] != '' && $_POST["Pays"] != '' && $_POST["CodePostal"] != '' && $_POST["Telephone"] != '' && $_POST["TypeRole"] != '') {
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
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['IdUtilisateur'] = $db->lastInsertId();
        $_SESSION['Pseudo'] = $_POST["identifiant"];
        $_SESSION['IdTypeRole'] = intval($_POST["TypeRole"]);
    } else {
        echo "<script>alert(\"Un champ est vide\")</script>";
    }
}
//Login, on liste les informations de l'utilisateur quand on appuie sur le bouton btn-login qui MATCH les informations entrées en INPUT
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
        if (count($result) > 0) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['IdUtilisateur'] = $result[0]['IdUtilisateur'];
            $_SESSION['Pseudo'] = $result[0]['Pseudo'];
            $_SESSION['IdTypeRole'] = $result[0]['IdTypeRole'];
        }
    }
}


// Delete User, qui match l'IdTypeUtilisateur si la session est Admin
if (isset($_GET['IdUtilisateur']) && isset($_SESSION['IdUtilisateur']) && $_SESSION['IdTypeRole'] == 1) {
    header('Location: compte.php');
    $sql = 'DELETE FROM utilisateur WHERE IdUtilisateur = :IdUtilisateur';
    $req = $db->prepare($sql);
    $req->execute(array(
        ':IdUtilisateur' => intval($_GET["IdUtilisateur"])
    ));
}

// Delete Article si la session est Admin ou Vendeur
if (isset($_GET['IdArticle']) && isset($_SESSION['IdUtilisateur']) && $_SESSION['IdTypeRole'] != 3) {
    header('Location: compte.php');
    $sql = 'DELETE FROM article WHERE IdArticle = :IdArticle';
    $req = $db->prepare($sql);
    $req->execute(array(
        ':IdArticle' => intval($_GET["IdArticle"])
    ));

    $sql = 'DELETE FROM panier WHERE IdArticle = :IdArticle';
    $req = $db->prepare($sql);
    $req->execute(array(
        ':IdArticle' => intval($_GET["IdArticle"])
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
                <li><a class="active" href="compte.php">Mon compte</a></li>
                <?php if (isset($_SESSION['IdUtilisateur'])) { ?>
                    <li><a href="panier.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                    <li><a href="disconnect.php"><i class="fa-solid fa-power-off"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <?php if (!isset($_SESSION['IdUtilisateur'])) { ?>
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
                    <!--On liste les Type de Role-->
                    <?php
                    $sql = 'SELECT * FROM TypeRole WHERE IdTypeRole != 1 ORDER BY IdTypeRole DESC';
                    $req = $db->prepare($sql);
                    $req->execute();
                    $result = $req->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <select name="TypeRole">
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
    <?php } ?>
    <!-- front login-->
    <?php
    if (isset($_SESSION['IdUtilisateur'])) {
        $sql = 'SELECT Pseudo, Email, Prenom, Nom, Photo, ImgFond AS Wallpaper, Adresse, Ville, Pays, CodePostal, Telephone, TypeRole AS Statut FROM utilisateur u LEFT JOIN typerole t ON t.IdTypeRole = u.IdTypeRole WHERE u.IdUtilisateur = :IdUtilisateur';
        $req = $db->prepare($sql);
        $req->execute(array(
            ':IdUtilisateur' => intval($_SESSION["IdUtilisateur"])
        ));
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $result = $result[0];
    ?>


        <section id="Page-Login" class="section-p1">

            <div class="Login-Container">

                <div class="Champ-User">
                    <table>

                        <?php
                        $array_keys = array_keys($result);
                        $i = 0;
                        foreach ($result as $row) {
                        ?>
                            <tr>
                                <td><?php echo $array_keys[$i]; ?> : </td>
                                <td>
                                    <?php if ($row != null) {
                                        echo $row;
                                    } else {
                                        echo '<i>Non défini</i>';
                                    } ?>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        } ?>
                    </table>
                </div>
            </div>
            <?php if (isset($_SESSION['IdUtilisateur']) && $_SESSION['IdTypeRole'] != 3) { ?>
                <div id="Ajout-Container">
                    <h2>Ajouter un article</h2>
                    <form method="POST" class="form-ajouter">
                        <input name="NomArticle" placeholder="Nom">
                        <br>
                        <input name="Marque" placeholder="Marque">
                        <br>
                        <input name="Img" placeholder="Image">
                        <br>
                        <input name="QuantiteMax" type="number" placeholder="Quantite">
                        <br>
                        <input name="Prix" type="number" placeholder="Prix">
                        <br>

                        <select name="IdTypeArticle">
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
                        <br>
                        <!--On liste les Type de Vente-->
                        <select name="IdTypeVente">
                            <?php
                            $sql = 'SELECT * FROM typevente';
                            $req = $db->prepare($sql);
                            $req->execute();
                            $result = $req->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                            ?>
                                <option value="<?php echo $row['IdTypeVente'] ?>"><?php echo $row['TypeVente'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <textarea name="Description"></textarea>
                        <br>
                        <button name="addArticle" type="submit" class="normal">Ajouter l'article</button>
                    </form>
                </div>
            <?php }

            // Création Article

            if (isset($_POST['addArticle'])) {
                if ($_POST["NomArticle"] != '' && $_POST["Marque"] != '' && $_POST["Img"] != '' && $_POST["QuantiteMax"] != '' && $_POST["Prix"] != '' && $_POST["IdTypeArticle"] != '' && $_POST["IdTypeVente"] != '') {
                    $sql = 'INSERT INTO article SET IdUtilisateur = :IdUtilisateur, NomArticle = :NomArticle, Marque = :Marque, Img = :Img, QuantiteMax = :QuantiteMax, Prix = :Prix, IdTypeArticle = :IdTypeArticle, DateExpBestOffer=:DateExpBestOffer,IdTypeVente = :IdTypeVente, Description = :Description';
                    $req = $db->prepare($sql);
                    $req->execute(array(
                        ':IdUtilisateur' => ($_SESSION['IdUtilisateur']),
                        ':NomArticle' => ($_POST["NomArticle"]),
                        ':Marque' => ($_POST["Marque"]),
                        ':Img' => ($_POST["Img"]),
                        ':QuantiteMax' => (intval($_POST["QuantiteMax"])),
                        ':Prix' => (floatval($_POST["Prix"])),
                        ':IdTypeArticle' => (intval($_POST["IdTypeArticle"])),
                        ':DateExpBestOffer' => ($_POST["DateExp"]),
                        ':IdTypeVente' => (intval($_POST["IdTypeVente"])),
                        ':Description' => ($_POST["Description"])
                    ));
                } else {
                    echo "<script>alert(\"Un champ obligatoire est vide\")</script>";
                }
            }
            ?>
            <!-- Liste Article (dynamique en fonction de l'admin ou du vendeur) -->
            <?php if (isset($_SESSION['IdUtilisateur']) && $_SESSION['IdTypeRole'] != 3) { ?>
                <div id="listea-container">
                    <h2>Liste articles</h2>
                    <table>
                        <thead>
                            <td>IdArticle</td>
                            <td>Nom</td>
                            <td>Categorie</td>
                            <td>Prix</td>
                            <td>Quantite</td>
                            <td>Proprietaire</td>
                            <td></td>
                        </thead>
                        <?php
                        if (isset($_SESSION['IdUtilisateur'])) {
                            $sql = 'SELECT a.IdArticle, a.NomArticle, a.QuantiteMax, t.TypeArticle, a.Prix, u.Pseudo AS Proprietaire FROM article a LEFT JOIN typearticle t ON t.IdTypeArticle = a.IdTypeArticle LEFT JOIN utilisateur u ON u.IdUtilisateur = a.IdUtilisateur WHERE (CASE WHEN (SELECT u.IdTypeRole FROM utilisateur u WHERE u.IdUtilisateur = :IdUtilisateur) = 1 THEN (a.IdArticle != 0) ELSE (a.IdUtilisateur = :IdUtilisateur) END)';
                            $req = $db->prepare($sql);
                            $req->execute((array(
                                ':IdUtilisateur' => $_SESSION['IdUtilisateur']
                            )));
                            $result = $req->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row['IdArticle']; ?></td>
                                    <td><?php echo $row['NomArticle']; ?></td>
                                    <td><?php echo $row['TypeArticle']; ?></td>
                                    <td><?php echo $row['Prix']; ?></td>
                                    <td><?php echo $row['QuantiteMax']; ?></td>
                                    <td><?php echo $row['Proprietaire']; ?></td>
                                    <td><a href="compte.php?IdArticle=<?php echo $row['IdArticle']; ?>"><i class="fa-solid fa-trash"></i></a></td>

                                </tr>
                        <?php }
                        } ?>
                    </table>
                </div>
            <?php } ?>


            <?php
            // Liste users
            if (isset($_SESSION['IdUtilisateur']) && $_SESSION['IdTypeRole'] == 1) { ?>
                <div id="listeu-container">
                    <h2>Liste utilisateurs</h2>
                    <table>
                        <thead>
                            <td>IdUtilisateur</td>
                            <td>Pseudo</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td></td>
                        </thead>
                        <?php
                        if (isset($_SESSION['IdUtilisateur'])) {
                            $sql = 'SELECT IdUtilisateur, Pseudo, Email, u.IdTypeRole, TypeRole FROM utilisateur u LEFT JOIN typerole t ON t.IdTypeRole = u.IdTypeRole ORDER BY DateCreation';
                            $req = $db->prepare($sql);
                            $req->execute();
                            $result = $req->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row['IdUtilisateur']; ?></td>
                                    <td><?php echo $row['Pseudo']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['TypeRole']; ?></td>
                                    <?php if ($row['IdTypeRole'] == 1) { ?>
                                        <td class="delete-disable"><i class="fa-solid fa-trash"></i></td>
                                    <?php } else { ?>
                                        <td><a href="compte.php?IdUtilisateur=<?php echo $row['IdUtilisateur']; ?>"><i class="fa-solid fa-trash"></i></a></td>
                                    <?php } ?>
                                </tr>
                        <?php }
                        } ?>
                    </table>
                </div>
            <?php } ?>

        </section>
    <?php } ?>
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