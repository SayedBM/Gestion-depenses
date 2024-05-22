<?php
require_once '../connexion.php';

$sqlU = "SELECT UtilisateurID FROM Utilisateur";

$stmtU = sqlsrv_query($conn, $sqlU);

// si erreur
if ($stmtU === false) {
    die(print_r(sqlsrv_errors(), true));
}

$idUUtilisees = [];
while ($row = sqlsrv_fetch_array($stmtU, SQLSRV_FETCH_ASSOC)) {
    $idUUtilisees[] = $row['UtilisateurID'];
}

// Verifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // récupérer les valeurs
    $utilisateurID = $_POST['utilisateur_id'];
    $nomU = $_POST['nom'];
    $emailU = $_POST['email'];
    $passU = $_POST['motDePasse'];

    $sql = "INSERT INTO Utilisateur (UtilisateurID, Nom, Email, MotDePasse) VALUES(?,?,?,?)";
    $params = array($utilisateurID, $nomU, $emailU, $passU);

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        // Gérer l'erreur de préparation
        die(print_r(sqlsrv_errors(), true));
    }

    // Exécuter la requête préparée
    $result = sqlsrv_execute($stmt);

    if ($result === false) {
        // Gérer l'erreur d'exécution
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo 'L\'utilisateur a été ajouté avec succès.';
        header('location: indexU.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Utilisateur</title>
</head>
<body>
<?php
        include "../style/header.php";

    ?>
    <div class="container">
        <h1>Ajouter Utilisateur</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="utilisateur_id" class="form-label">Identifiant :</label>
                <input type="text" name="utilisateur_id" list="utilisateur_List" class="form-control">
                <datalist id="utilisateur_List">
                    <?php foreach ($idUUtilisees as $util) : ?>
                        <option value="<?php echo $util; ?>">
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom et Prénom :</label>
                <input type="text" name="nom" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail :</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="motDePasse" class="form-label">Mot de passe :</label>
                <input type="text" name="motDePasse" class="form-control">
            </div>

            <input type="submit" name="submit" value="Ajouter utilisateur" class="btn btn-primary">
        </form>
    </div>
    <?php
        include "../style/footer.php";

    ?>
</body>
</html>