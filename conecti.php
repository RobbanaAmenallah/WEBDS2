<?php
function connect() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "blog";

    try {
        $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; 
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null; 
    }
}

$conn = connect();
if ($conn) {
    echo "";
   
} else {
    echo "Échec de la connexion.";
}
?>

