<?php
include 'admin.php';

function update(PDO $pdo) {
    $username = $_POST['T1'];
    $email = $_POST['T2'];
    $password = $_POST['T3'];

    try {
        $stmt = $pdo->prepare("UPDATE user SET mail = :mail, password = :password WHERE nom = :nom");

        // bch norbtou el parametres
        $stmt->bindParam(':nom', $username);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        return true; //  mise a jour saret
    } catch (PDOException $e) {
        // Gérer les erreurs
        echo "Erreur: " . $e->getMessage();
        return false; // allah ghaleb ma sarech mise a jour
    }
}

// Appel de la fonction update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (update($conn)) { 
        echo "Enregistrement mis à jour avec succès.";
    } else {
        echo "Échec de la mise à jour de l'enregistrement.";
    }
}
?>
