<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['liked'])) {
    // Récupérer le titre de l'article à incrémenter
    $articleTitre = $_POST['liked'];

    try {
        // Inclure le fichier de connexion à la base de données
        require_once 'conecti.php';

        // Préparer et exécuter la requête SQL pour incrémenter le rapport
        $sql = "UPDATE ajoutblog2 SET liked = liked + 1 WHERE titre = :articleTitre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':articleTitre', $articleTitre);
        $stmt->execute();

        // Rediriger vers la page précédente ou une autre page après l'incrémentation
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    // Rediriger vers une autre page si le formulaire n'a pas été soumis correctement
    header("Location: index2.php"); // Modifier index.php selon votre besoin
    exit();
}
?>
