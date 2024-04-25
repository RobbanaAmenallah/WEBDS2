<?php
// Inclure le fichier de connexion à la base de données
require_once 'conecti.php';

// Vérifier si le titre de l'article est passé dans l'URL
if(isset($_GET['titre']) && !empty($_GET['titre'])) {
    $article_titre = $_GET['titre'];}  
   
    // Récupérer les données de l'article depuis la base de données
   
        $stmt = $conn->prepare("SELECT * FROM ajoutblog WHERE titre = :titre");
        $stmt->bindParam(':titre', $article_titre);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC)
        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog sur la Palestine</title>
    <!-- Ajouter le lien vers le fichier CSS Bootstrap -->
    <link rel="stylesheet" href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css">
    <style>
        /* Styles personnalisés */
        body {
            background-color: #f4f4f4;
        }
        header {
            background-color: #135D66;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        .article-container {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            text-align:right;

        }
        .article-info {
            width: 40%;
            padding: 0 20px;
        }
        .article-info h1 {
            font-size: 24px;
        }
        .article-info h3 {
            font-size: 18px;
            color: #888;
        }
        .article-photo {
            width: 30%;
            padding: 0 20px;
        }
        .article-content {
            width: 60%;
            padding: 0 20px;
        }
        .comment-submit-btn {
            margin-top: 20px;
            display: none; /* Rendre le bouton invisible par défaut */
        }
        footer{
            background:#135D66;
            color: #fff;
            text-align:center;
        }
        textarea{
            text-align:right;
        }
    </style>
</head>
<body>
    <header>
        <h1>مدونة عن فلسطين</h1>
    </header>
    <div class="container article-container">
    <?php
    // Vérifier si le titre de l'article est passé dans l'URL
    if(isset($_GET['titre']) && !empty($_GET['titre'])) {
        $article_titre = $_GET['titre'];
       
        // Récupérer les données de l'article depuis la base de données
        $stmt = $conn->prepare("SELECT * FROM ajoutblog2 WHERE titre = :titre");
        $stmt->bindParam(':titre', $article_titre);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer la photo de l'article depuis la base de données
        $stmt_photo = $conn->prepare("SELECT photo FROM photos WHERE titre = :titre");
        $stmt_photo->bindParam(':titre', $article_titre);
        $stmt_photo->execute();
        $photo = $stmt_photo->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="article-info">
        <h1><?php echo $article['titre']; ?></h1>
        <h3><?php echo $article['date']; ?></h3>
        <?php if ($photo && !empty($photo['photo'])): ?>
            <img src="<?php echo $photo['photo']; ?>" alt="Photo de l'article" class="img-fluid">
        <?php endif; ?>
    </div>
    <div class="article-photo">
       
    </div>
    <div class="article-content">
        <p><?php echo $article['contenue']; ?></p>
        <!-- Insérer le formulaire de commentaire ici -->
    </div>
    <?php } else {
        echo "Titre de l'article non spécifié.";
    } ?>
</div>

        <div class="article-content">
           
            <div id="commentSection" style="display: none; text-align: center; margin-top: 20px;">
    <form id="commentForm" action="" method="POST">
        <?php
require_once 'conecti.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['commentaire']) && !empty($_POST['commentaire']) && isset($_POST['titre']) && !empty($_POST['titre'])) {
        $titre = $_POST['titre'];
        $commentaire = $_POST['commentaire'];
       
        try {
            $stmt = $conn->prepare("INSERT INTO comments2 (titre, commentaire) VALUES (:titre, :commentaire)");
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}
?>

        <textarea name="commentaire" id="commentText" rows="4" cols="50" placeholder="اضافة تعليق"></textarea>
        <input type="hidden" name="titre" value="<?php echo $article['titre']; ?>">
        <button type="submit" class="btn btn-primary comment-submit-btn" onclick="checkArabicText()">إرسال</button>
    </form>
</div>

            <?php
                echo '<button class="btn btn-primary" onclick="toggleComment()">تعليق</button>';
                echo '</div>';
               
                // Zone de texte pour les commentaires (initialement masquée)
                echo '<div id="commentSection" style="display: none; text-align: center; margin-top: 20px;">';
                echo '<textarea id="commentText" rows="4" cols="50" placeholder="اضافة تعليق"></textarea>';
                echo '</div>';
            ?>
            <button class="btn btn-primary comment-submit-btn">إرسال</button>
        </div>
    </div>
    <div id="commentairesSection" style="text-align: center; margin-top: 20px;">
    <h4> : التعليقات</h4>
    <?php
    try {
        $stmt = $conn->prepare("SELECT * FROM comments2 WHERE titre = :titre");
        $stmt->bindParam(':titre', $article_titre);
        $stmt->execute();
        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($commentaires as $commentaire) {
            echo "<p>Anonyme :" . $commentaire['commentaire'] . "</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
    ?>
</div>
<footer>
    <p>&copy; 2024 مدونة عن فلسطين</p>
</footer>

    <script>
        function toggleComment() {
            var commentSection = document.getElementById("commentSection");
            var commentSubmitBtn = document.querySelector(".comment-submit-btn");
            if (commentSection.style.display === "none") {
                commentSection.style.display = "block";
                commentSubmitBtn.style.display = "block"; // Afficher le bouton Envoyer
            } else {
                commentSection.style.display = "none";
                commentSubmitBtn.style.display = "none"; // Cacher le bouton Envoyer
            }
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


