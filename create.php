<?php
include 'admin.php';



function createUser($username, $address, $password, $conn) {
    $sql = "INSERT INTO user (nom,mail,password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username,$address,$password]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['T1'];
    $address = $_POST['T2'];
    $password = $_POST['T3'];
    
    // Create user
    createUser($username, $address, $password, $conn);

}

?>