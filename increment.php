<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['increment_report'])) {
    // Récupérer le titre de l'article à incrémenter
    $articleTitre = $_POST['increment_report'];

    try {
        // Inclure le fichier de connexion à la base de données
        require_once 'conecti.php';

        $sql = "UPDATE ajoutblog SET report = report + 1 WHERE titre = :articleTitre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':articleTitre', $articleTitre);
        $stmt->execute();

        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    header("Location: index.php"); 
    exit();
}
?>
