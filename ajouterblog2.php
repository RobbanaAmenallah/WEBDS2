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
        $sql = "INSERT INTO ajoutblog2 (titre, date, contenue) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$t, $d, $c]);

        header("location: index2.php"); // Rediriger après l'ajout
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
        body{      direction: rtl; /* Définir la direction de l'écriture de droite à gauche */
}
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
        <li><a href="index2.php">إستقبال</a></li>
            <li><a href="news2.html">أخبار</a></li>
            <li><a href="histoire2.html">عن فلسطين </a></li>
        </ul>
    </nav>
    <h1>مدونة عن فلسطين</h1>
</header>

<div class="container">
    <div class="card bg-light p-3">
        <h2>شارك رأيك</h2>
        <main>
            <form method="POST" onsubmit="return checkArabicText()" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">حدد صورة:</label>
                    <input type="file" class="form-control-file" id="photo" name="fileToUpload">
                </div>
                <div class="form-group">
                    <h3>عنوان</h3>
                    <input type="text" class="form-control" name="T1">
                    <br>
                    <h3>اكتب مدونة:</h3>
                    <textarea class="form-control" id="blogTextarea" rows="5"  name="tx1"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">يرسل :</button>
            </form>
            </main>
    </div>َ
    <audio id="soundEffect">
        <source src="audio.mp3" type="audio/mpeg">
        Votre navigateur ne supporte pas l'élément audio.
    </audio>
    <button id="btnPlay" class="btn btn-primary">تشغيل الموسيقى</button>
    <button id="btnStop" class="btn btn-danger">أوقف الموسيقى</button>
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

    function isArabic(text) {
    // Utilisation d'une expression régulière pour vérifier si le texte est en arabe
    const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
    return arabicRegex.test(text);
  }

  function checkArabicText() {
    const textInput = document.getElementById('blogTextarea').value;
    
    if (!isArabic(textInput)) {
      alert("النص الفرنسي غير مقبول.");
      return false; // Empêche l'envoi du formulaire si le texte n'est pas en arabe
    }
    return true;
}
</script>
</body>
</html>
