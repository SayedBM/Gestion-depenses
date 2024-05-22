<?php
require_once '../connexion.php';

$id = (int)$_GET['id'];

// Récupération de l'utilisateur en question
$sql = "SELECT * FROM Utilisateur WHERE UtilisateurID = ?";
$params = array($id);
$stmt = sqlsrv_query($conn, $sql, $params);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles valeurs
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];

    // Mettre à jour
    $sql = "UPDATE Utilisateur SET Nom = ?, Email = ?, MotDePasse = ? WHERE UtilisateurID = ?";
    $params = array($nom, $email, $motDePasse, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo 'Erreur lors de la mise à jour de l utilisateur.';
    } else {
        echo 'Utilisateur a été mis à jour avec succès.';
        header('location: indexU.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Utilisateur</title>
</head>
<body>
<?php
        include "../style/header.php";

    ?>
    <div class="container">
        <h1>Modifier un Utilisateur</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom et Prénom :</label>
                <input type="text" class="form-control" name="nom" value="<?php echo $row['Nom']; ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>">
            </div>

            <div class="mb-3">
                <label for="motDePasse" class="form-label">Mot de Passe :</label>
                <input type="text" class="form-control" name="motDePasse" value="<?php echo $row['MotDePasse']; ?>">
            </div>

            <input type="submit" class="btn btn-primary" name="submit" value="Enregistrer les modifications">
        </form>
    </div>
    <?php
        include "../style/footer.php";

    ?>
</body>
</html>