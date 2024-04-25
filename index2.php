<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدونة عن فلسطين</title>
    <!-- Ajouter le lien vers le fichier CSS Bootstrap -->
    <link rel="stylesheet" href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css">
    <style type="text/css">
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            direction: rtl; /* Définir la direction de l'écriture de droite à gauche */

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
            text-align: 10px;
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

        main {
            padding: 20px;
        }

        .articles {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centrage horizontal */
        }

        article {
            background-color: #fff;
            padding: 80px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Espace entre les articles */
            max-width: 600px; /* Largeur maximale de l'article */
        }

        article h2 {
            margin-bottom: 10px;
        }
        img {
            max-width: 100%; /* La largeur de l'image ne dépassera pas la largeur de l'article */
            height: auto; /* La hauteur s'ajustera automatiquement pour conserver les proportions */
        }

        .meta {
            color: #888;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }

        .btn:hover {
            background-color: #555;
        }

        .logo {
            position: absolute; 
            top: 100px; 
            left: 0px;
            width: 200px; 
            height: auto;  
            z-index: 1000; 
        }

        .article-textarea {
            width: 100%;
            height: auto; 
            min-height: 100px; 
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            resize: none;
        }
        footer{
            background:#135D66;
            color: #fff;
        }
        .chatroom-image{position: absolute; 
            top: 100px;
            right: 0px; 
            width: 200px; 
            height: auto; 
            z-index: 1000;}

    </style>
</head>
<body>
<header>
    <img src="flag.png" alt="Logo" class="logo">
    <nav>
        <ul>
        <li><a href="histoire2.html">عن فلسطين </a></li>
            <li><a href="news2.html">أخبار</a></li>
            <li><a href="ajouterblog2.php">أضف مدونة </a></li>
            <li><a href="imageboycott/test.html">مقاطعة</a></li>

        </ul>
    </nav>
    <h1>مدونة عن فلسطين</h1>
    <a href="chatroom2.php"><img src="chatroom.png" alt="Chatroom" class="chatroom-image"></a>

</header>

<main>
    <section class="articles">

        <?php
        // Inclure le fichier de connexion à la base de données
        require_once 'conecti.php';

        // Récupérer les données de la base de données
        try {
            $stmt = $conn->query("SELECT a.titre, a.date, a.contenue, p.photo,a.liked FROM ajoutblog2 a LEFT JOIN photos p ON a.titre = p.titre");
            $donnees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Afficher les données dans des articles avec leurs photos
            foreach ($donnees as $row) {
                echo '<article>';
                echo '<h2>' . $row['titre'] . '</h2>';
                echo '<p class="meta">' . $row['date'] . '</p>';
                if (!empty($row['photo'])) {
                    $imagePath = $row['photo'];
                    echo '<img src="' . $imagePath . '" alt="Image">';
                }
                echo '<h5>عدد الإعجابات' . $row['liked'] . '</h5>';

                echo '<a href="article_complet2.php?titre=' . $row['titre'] . '" class="btn btn-primary">اقرأ المزيد                </a>';
            
                // Formulaire pour incrémenter le rapport
                echo '<form action="increment2.php" method="POST">';
                echo '<input type="hidden" name="increment_report" value="' . $row['titre'] . '">';
                echo '<button type="submit" class="btn btn-danger">تقرير</button>';
                echo '</form>';
                echo '<form action="liked2.php" method="POST">';
                echo '<input type="hidden" name="liked" value="' . $row['titre'] . '">';
                echo '<button type="submit" class="btn btn-danger">إعجاب</button>';
                echo '</form>';
                echo '</article>';
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
       
    </section>
</main>


<footer>
    <p>&copy; 2024 مدونة عن فلسطين</p>
</footer>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js">

</script>
</body>
</html>
