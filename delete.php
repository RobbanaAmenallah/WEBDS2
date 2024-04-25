<?php
include 'admin.php'; 

function delete(PDO $pdo, $username) {
    try {
        $stmt = $pdo->prepare("DELETE FROM user WHERE nom = :username");

        // bch norbtou el parametres
        $stmt->bindParam(':username', $username);

        // Exécuter mta3 requête
        $stmt->execute();

        return true; // fassa5neh b najeh
    } catch (PDOException $e) {
        // Gérer les erreurs
        echo "Erreur: " . $e->getMessage();
        return false; // tafsi5a ma mchetech
    }
}

// bch n3aytou lel fonction elli tfassa5
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['T1']; 
    if (delete($conn, $username)) { 
        echo "Enregistrement supprimé avec succès.";
    } else {
        echo "Échec de la suppression de l'enregistrement.";
    }
}

?>
