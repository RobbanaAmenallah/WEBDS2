<?php
include 'conecti.php';

class Admin {
    private $id;
    private $username;
    private $password;

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // bch na3mlou hydratation lel objet admin avec un tableau
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // CRUD 

    // Cbch nasn3ou user jdid
    public function create(PDO $pdo) {
        $stmt = $pdo->prepare("INSERT INTO user (nom,mail,password) VALUES (?,?,?)");
        
        return $stmt->execute();
    }

    // bch nlawjou ala user
    public static function getById(PDO $pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin = new Admin();
        $admin->hydrate($data);
        return $admin;
    }

    // bch na"mlou update l user 
    public function update(PDO $pdo) {
        $stmt = $pdo->prepare("UPDATE user SET id = :id, password = :password WHERE nom = :username");
        $stmt->bindParam(':username', $this->nom);
        $stmt->bindParam(':email', $this->mail);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    // bch nfasskhou user
    public function delete(PDO $pdo) {
        $stmt = $pdo->prepare("DELETE FROM user WHERE nom = :username");
        $stmt->bindParam(':username', $this->nom);
        return $stmt->execute();
    }
        // bch nfasskhou blog franc
        public function delete2(PDO $pdo) {
            $stmt = $pdo->prepare("DELETE FROM ajoutblog WHERE titre = :titre");
            $stmt->bindParam(':titre', $this->titre);
            return $stmt->execute();
        }
        // bch nfasskhou blog 3arbi
        public function delete3(PDO $pdo) {
            $stmt = $pdo->prepare("DELETE FROM ajoutblog2 WHERE titre = :titre");
            $stmt->bindParam(':titre', $this->titre);
            return $stmt->execute();
        }



        public function getNombreMaxReport(PDO $pdo) {
            $stmtReport = $pdo->query("SELECT COUNT(*) FROM user");
            return $stmtReport->fetchColumn();
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RT Blogeur</title>
    <link href="vendor\twbs\bootstrap\dist\css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .tab {
            width: 100%;
        }

        .tab td {
            padding: 8px;
        }

        .titre {
            text-align: center;
            margin-bottom: 30px;
        }

        @media (max-width: 576px) {
            .login-box {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="logo-container">
    <img src="aboub.jpg" alt="Logo">
</div>
<div class="login-box">
    <h1 class="titre">CRUD ADMIN</h1>

    <h2 class="add">Ajouter un nouveau utilisateur</h2>
    <form action="create.php" method="post" id="f1">
        <div class="form-group">
            <label for="username">Nom</label>
            <input type="text" id="username" name="T1" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_username">Email</label>
            <input type="text" id="new_username" name="T2" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">MDP</label>
            <input type="password" id="password" name="T3" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <br>
    <div class="message-indicatif">
    <div class="alert alert-info" role="alert">
        Le nombre d'utilisateurs est :
        <?php
        // Connexion m3a l base
        require_once 'conecti.php';

        // Récupérer le nombre d'utilisateurs de la base de données
        try {
            $stmt = $conn->query("SELECT COUNT(*) AS user_count FROM user");
            $donnees = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($donnees && isset($donnees['user_count'])) {
                echo '<h2>' . $donnees['user_count'] . '</h2>';
            } else {
                echo "Le nombre d'utilisateurs n'a pas pu être récupéré.";
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
    </div>
</div>



    <h2 class="update">Mise à jour d'un utilisateur</h2>
    <form action="update.php" method="post" id="f2">
        <div class="form-group">
            <label for="update_id">Nom</label>
            <input type="text" id="update_id" name="T1" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_username">E-mail</label>
            <input type="text" id="new_username" name="T2" class="form-control">
        </div>
        <div class="form-group">
            <label for="new_password">Password</label>
            <input type="password" id="new_password" name="T3" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Mise à jour</button>
    </form>

    <h2 class="delete">Suppression d'un utilisateur</h2>
    <form action="delete.php" method="post" id="f3">
        <div class="form-group">
            <label for="delete_id">Nom</label>
            <input type="text" id="delete_id" name="T1" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>

    <h2 class="select">Supprimer Un Blog francais</h2>
    <form action="delete2.php" method="post" id="f4">
        <div class="form-group">
            <label for="admin_id">Titre</label>
            <input type="text" id="admin_id" name="T1" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Supprimer</button>
    </form>
    <br>
    <div class="message-important">
            <div class="alert alert-danger" role="alert">
                Attention ! C'est le blog Francais le plus signalée.
                 <?php
        // Inclure le fichier de connexion à la base de données
        require_once 'conecti.php';

        // Récupérer les données de la base de données
        try {
            $stmt = $conn->query("SELECT titre, report FROM ajoutblog ORDER BY report DESC LIMIT 1");
            $donnees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Afficher les données dans des articles avec leurs photos
            foreach ($donnees as $row) {
                echo '<article>';
                echo '<h5>' . $row['titre'] . '</h5>';
                echo '<p>' . $row['report'] . '</p>';
				echo '</article>';
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }

        ?>
            </div>
        </div>
        <h2 class="select">Supprimer Un Blog arabe</h2>
    <form action="delete3.php" method="post" id="f4">
        <div class="form-group">
            <label for="admin_id">Titre</label>
            <input type="text" id="admin_id" name="T1" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">Supprimer</button>
    </form>
    <br>
    <div class="message-important">
            <div class="alert alert-danger" role="alert">
            Attention ! C'est le blog Arabe le plus signalée.
                 <?php
        // Inclure le fichier de connexion à la base de données
        require_once 'conecti.php';

        // Récupérer les données de la base de données
        try {
            $stmt = $conn->query("SELECT titre, report FROM ajoutblog2 ORDER BY report DESC LIMIT 1");
            $donnees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Afficher les données dans des articles avec leurs photos
            foreach ($donnees as $row) {
                echo '<article>';
                echo '<h5>' . $row['titre'] . '</h5>';
                echo '<p>' . $row['report'] . '</p>';
				echo '</article>';
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        ?>
            </div>
        </div>
</div>

<script src="vendor\twbs\bootstrap\dist\js/bootstrap.min.js"></script>
</body>
</html>
