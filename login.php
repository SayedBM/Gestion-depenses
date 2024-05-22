<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $mdp = $_POST['mdp'];

    require_once 'connexion.php';

    // Hacher le mot de passe saisi par l'utilisateur avec SHA-256
    $mdpHache = hash('sha256', $mdp);

    $tsql = "update utilisateur set mdpHache = '$mdpHache' where email = '$user'";
    $params = array($mdpHache);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        echo 'Erreur d\'insertion.';
    } else {
        echo 'Utilisateur enregistré avec succès.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center">Connexion</h1>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="utilisateur" class="form-label">Email :</label>
                                <input type="text" name="user" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="motDePasse" class="form-label">Mot de Passe :</label>
                                <input type="password" name="mdp" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>