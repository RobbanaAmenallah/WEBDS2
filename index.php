<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog sur la Palestine</title>
    <link rel="stylesheet" href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css">
    <style type="text/css">
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
        }

        header {
            background:#135D66;
            color: #fff;
            padding: 20px;
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        header h1 {
            margin-bottom: 10px;
            font-family: "Times New Roman", serif; 
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
            font-family: "Times New Roman", serif; 
        }

        main {
            padding: 20px;
        }

        .articles {
            display: flex;
            flex-direction: column;
            align-items: center; 
        }

        article {
            background-color: #fff;
            padding: 80px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
            max-width: 600px; 
        }

        article h2 {
            margin-bottom: 10px;
        }
        img {
            max-width: 100%; 
            height: auto; 
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
    
    .image-container {
        max-width: 100%;
        overflow: hidden;
    }

    .article-image {
        max-width: 100%;
        height: auto;
    }
    .chatroom-image{position: absolute; 
            top: 100px;
            right: 0px; 
            width: 200px; 
            height: auto; 
            z-index: 1000;}
</style>
    </style>
</head>
<body>
<header>
    <img src="flag.png" alt="Logo" class="logo">
    <nav>
        <ul>
            <li><a href="histoire.html">À propos Palestine</a></li>
            <li><a href="news.html">Actualité</a></li>
            <li><a href="ajouterblog.php">Ajouter Un Blog</a></li>
            <li><a href="imageboycott/test.html">Boycott</a></li>
        </ul>
    </nav>
    <h1>Blog sur la Palestine</h1>
    <a href="chatroom.php"><img src="chatroom.png" alt="Chatroom" class="chatroom-image"></a>
</header>

<main>
<section class="articles">
<?php
require_once 'conecti.php';

// Récupérer les données de la base de données avec les photos
try {
    $stmt = $conn->query("SELECT a.titre, a.date, a.contenue, p.photo ,a.liked FROM ajoutblog a LEFT JOIN photos p ON a.titre = p.titre");
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
        echo '<h5>Nombre De Likes :' . $row['liked'] . '</h5>';

        echo '<a href="article_complet.php?titre=' . $row['titre'] . '" class="btn btn-primary">Lire la suite</a>';
    
        // Formulaire pour incrémenter le rapport
        echo '<form action="increment.php" method="POST">';
        echo '<input type="hidden" name="increment_report" value="' . $row['titre'] . '">';
        echo '<button type="submit" class="btn btn-danger">Signaler</button>';
        echo '</form>';
        echo '<form action="liked.php" method="POST">';
        echo '<input type="hidden" name="liked" value="' . $row['titre'] . '">';
        echo '<button type="submit" class="btn btn-danger">Like</button>';
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
    <p>&copy; 2024 Blog sur la Palestine</p>
</footer>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
