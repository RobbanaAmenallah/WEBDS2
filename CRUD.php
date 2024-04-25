<?php
include 'conecti.php';

// bch nchoufou el method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $_POST['T1']; 

    // bch nchoufou el admin mawjoud wallé 
    $sql = "SELECT * FROM admin WHERE id=:id";
    
    // bch na3mlou requet preparé
    $stmt = $conn->prepare($sql);

    // norbtou el parametre b requet
    $stmt->bindParam(':id', $id);

    // exuction mta3 requet
    if ($stmt->execute()) {
        // Check if admin with provided ID exists
        if ($stmt->rowCount() > 0) {
          header("location: admin.php");

        } else {
            echo "Admin not found";
        }
    } else {
        // Handle query execution error
        echo "Error executing query: " . $stmt->errorInfo()[2];
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin</title>
    <link href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            background-image: url('0.jpg');
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
            color: #fff; /* Couleur du texte blanc */
        }

        .form-label {
            color: #fff; /* Couleur du texte blanc pour les labels */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 transparent-bg">
                <h2 class="mb-4">Espace Admin</h2>
                <form id="loginForm"  method="post" action="" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="T1" required>
                        <div class="invalid-feedback">ID is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" class="form-control" id="username" name="T2" required>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="T3" required>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>
                    <button type="submit" class="btn btn-success">Bouton Succès</button>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>