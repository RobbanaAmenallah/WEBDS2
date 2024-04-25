<?php

include 'conecti.php';
require_once 'vendor/autoload.php';

function searchuser($username, $password, $conn) {
  $sql = "SELECT * FROM user WHERE nom=? AND password=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username, $password]); // Utilisation d'un tableau pour les valeurs
  $user = $stmt->fetch();
  return $user; // Retourne l'utilisateur trouvé ou null s'il n'existe pas
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['T1'];
    $password = $_POST['T2'];
   
    $user = searchuser($username, $password, $conn);
   
    if ($user) {
        echo "Utilisateur existe";
        // Rediriger vers une page appropriée après la connexion réussie
        header("Location: langue.html");
        exit(); // Assure que le script s'arrête après la redirection
    } else {
        echo "L'utilisateur n'existe pas";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
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
                <h2 class="mb-4">Login</h2>
                <form id="loginForm"  method="post" action="" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="T1" required>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="T2" required>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>


</body>
</html>