<?php

include 'conecti.php';
require_once 'vendor/autoload.php';

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
    header("location: langue.html");

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('palestine.png');
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .transparent-bg {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            color: #fff; 
        }

        .form-label {
            color: #fff; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 transparent-bg">
                <h2 class="mb-4">SignUp</h2>
                <form id="loginForm"  method="post" action="" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="T1" required>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="T2" required>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="T3" required>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">SignUp</button>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>