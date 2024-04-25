<?php
include 'admin.php'; 

function delete2(PDO $pdo, $titre) { // Changer le nom du paramètre à $titre
    try {
        $stmt = $pdo->prepare("DELETE FROM ajoutblog WHERE titre = :titre"); // Utiliser le bon nom de paramètre

        // Binde el parametre correctement
        $stmt->bindParam(':titre', $titre); // Utiliser :titre comme nom de paramètre

        // Exécuter la requête
        $stmt->execute();

        return true; // La suppression s'est faite avec succès
    } catch (PDOException $e) {
        // Gérer les erreurs
        echo "Erreur: " . $e->getMessage();
        return false; // La suppression a échoué
    }
}


// bch n3aytou lel fonction elli tfassa5
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['T1']; 
    if (delete2($conn, $username)) { 
        echo "Enregistrement supprimé avec succès.";
    } else {
        echo "Échec de la suppression de l'enregistrement.";
    }
}

?>

