<?php
// Inclure le fichier de connexion à la base de données
require_once 'conecti.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $t = $_POST['T1'];
    $d = date("Y-m-d H:i:s");
    $c = $_POST['tx1'];
    
    // Vérifier si les champs sont vides
    if (!empty($t) && !empty($c)) {
        // Vérifier si le fichier a été téléchargé avec succès
        if ($_FILES["fileToUpload"]["error"] == 0) {
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);

            // Déplacer le fichier téléchargé vers le répertoire cible
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                // Récupérer le chemin relatif du fichier téléchargé
                $imagePath = $targetDirectory . $_FILES["fileToUpload"]["name"];

                // Insérer le chemin de l'image dans la base de données
                $sql = "INSERT INTO photos (titre, photo) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$t, $imagePath]);

                echo "Le fichier " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " a été téléchargé et enregistré dans la base de données.";
            } else {
                echo "Une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }

        // Insérer le blog dans la base de données
        $sql = "INSERT INTO ajoutblog (titre, date, contenue) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$t, $d, $c]);

        header("location: index.php"); // Rediriger après l'ajout
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partager Votre Avis</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css">
    <style>
        header {
            background:#135D66;
            color: #fff;
            padding: 20px;
            display: flex; /* Add flexbox */
            justify-content: space-between; /* Align items at the ends */
            align-items: center; /* Vertically center items */
        }

        header h1 {
            margin-bottom: 10px;
            font-family: "Times New Roman", serif; /* Change font family */
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            display: inline;
            margin-left: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-family: "Times New Roman", serif; /* Change font family */
        }

        h2 {
            margin-bottom: 10px;
            font-family: "Times New Roman", serif;
            color: black;
        }

        h3 {
            font-family: "Times New Roman", serif;
            color: black;
        }
    </style>
</head>
<body background="palestine.png">
<header>
    <nav>
        <ul>
            <li><a href="index.php">Acceuil</a></li>
            <li><a href="news.html">Actualité</a></li>
            <li><a href="histoire.html">À propos Palestine</a></li>
        </ul>
    </nav>
    <h1>Blog sur la Palestine</h1>
</header>

<div class="container">
    <div class="card bg-light p-3">
        <h2>Partager Votre Avis</h2>
        <main>
            <form method="POST" onsubmit="return checkFrenchText()" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">Sélectionnez une photo :</label>
                    <input type="file" class="form-control-file" id="photo" name="fileToUpload">
                </div>
                <div class="form-group">
                    <h3>Titre</h3>
                    <input type="text" class="form-control" name="T1">
                    <br>
                    <h3>Écrire Un Blog</h3>
                    <textarea class="form-control" id="blogTextarea" rows="5" placeholder="Écrivez votre avis ici" name="tx1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
            </form>
            </main>
    </div>
    <audio id="soundEffect">
        <source src="audio.mp3" type="audio/mpeg">
        Votre navigateur ne supporte pas l'élément audio.
    </audio>
    <button id="btnPlay" class="btn btn-primary">Lire la musique</button>
    <button id="btnStop" class="btn btn-danger">Stop la musique</button>
</div>

<!-- Inclure Bootstrap JS (optionnel, si nécessaire) -->
<script src="vendor\twbs\bootstrap\dist\js/bootstrap.min.js"></script>
<script>
    var audio = document.getElementById('soundEffect');
    var btnPlay = document.getElementById('btnPlay');
    var btnStop = document.getElementById('btnStop');

    btnPlay.addEventListener('click', function() {
        audio.play();
    });

    btnStop.addEventListener('click', function() {
        audio.pause();
        audio.currentTime = 0; // Réinitialiser la lecture à 0 secondes
    });
    function isArabic(text) {
        // Utilisation d'une expression régulière pour vérifier si le texte est en arabe
        const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
        return arabicRegex.test(text);
    }

    function checkFrenchText() {
        const textInput = document.getElementById('blogTextarea').value;
        
        if (isArabic(textInput)) {
            alert('Le texte en arabe n\'est pas accepté.');
            return false; // Empêcher l'envoi du formulaire
        }

        return true; // Autoriser l'envoi du formulaire
    }
</script>
</body>
</html>
