<?php
// Connexion à la base de données
require_once 'conecti.php';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération du message depuis le formulaire
    $message = $_POST['message'];
   
    // Insertion du message dans la base de données
    $sql = "INSERT INTO chatroom2 (message) VALUES (:message)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
   
    // Redirection vers la page de chat après l'envoi du message
    header("Location: chatroom2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
        <link href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css" rel="stylesheet">
         <style>
        body {
            background-color: #f4f4f4;
        }
        header {
            background-color: #135D66;
            color: white;
            text-align: center;
            padding: 10px;
        }
         header h1 {
            margin-bottom: 10px;
            font-family: "Times New Roman", serif; /* Change font family */

        }
        .chat-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        .messages {
            max-width: 500px;
            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
         button[type="submit"] {
            width: 80px; /* Taille du bouton */
            flex-shrink: 0; /* Empêcher le rétrécissement du bouton */
        }
        input[type="text"] {
            width: calc(100% - 90px); /* Largeur moins la taille du bouton */
            max-width: 500px; /* Limiter la largeur pour s'aligner avec les messages */
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        form {
            display: flex;
            align-items: center;
        }
        input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }
        .cr{
            position: absolute; /* Position absolue pour la positionner par rapport à la fenêtre */
            top: 100px; /* À une distance de 20 pixels du haut */
            left: 0px; /* À une distance de 20 pixels de la gauche */
            width: 200px; /* Largeur de l'image */
            height: auto; /* Hauteur automatique pour maintenir les proportions */
            z-index: 1000;
        }
        footer{
            background:#135D66;
            color: #fff;
            margin-bottom: 100px;


        }
        nav ul {
            list-style: none;
                        align-content: left;

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
        .messages{
            text-align:right;
        }

    </style>
</head>
<body>

<header>
    <img src="chatroom.png" alt="Chatroom Image"  class="cr">
<h1>محادثة</h1>
   
    <nav>
        <ul>
        <li><a href="histoire2.html">عن فلسطين </a></li>
        <li><a href="news2.html">أخبار</a></li>
        <li><a href="ajouterblog2.php">أضف مدونة </a></li>
            <li><a href="index2.php">إستقبال</a></li>
            <li><a href="imageboycott/test.html">مقاطعة</a></li>


        </ul>
    </nav>
   
</header>
<img src="chatroom.png" alt="Chatroom Image"  class="cr">
<div class="chat-container">
    <div class="messages">
        <?php
        // Connexion à la base de données
        require_once 'conecti.php';

        // Récupération des messages depuis la base de données
        $sql = "SELECT * FROM chatroom2";
        $stmt = $conn->query($sql);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des messages
        foreach ($messages as $message) {
            echo "<p><b>Anonyme:</b> " . $message['message'] . "</p>";
        }
        ?>
    </div>
    <form onsubmit="return checkArabicText()" method="POST">
        <input type="text" name="message" placeholder="رسالتك">
        <button type="submit"  class="btn btn-primary">إرسال</button>
    </form>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<footer>
    <p>&copy; 2024 مدونة عن فلسطين</p>
</footer>
<!-- Lien vers le fichier JavaScript de Bootstrap -->
<script src="vendor\twbs\bootstrap\dist\js/bootstrap.bundle.min.js"></script>
<script>function isArabic(text) {
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
}</script>

</div>

</body>
</html>
