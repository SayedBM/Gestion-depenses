<?php
require_once '../connexion.php';

$id = (int)$_GET['id'];

// Récupération de la catégorie en question
$sql = "SELECT * FROM CategorieDepenses WHERE CategorieID = ?";
$params = array($id);
$stmt = sqlsrv_query($conn, $sql, $params);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles valeurs
    $nom = $_POST['nom'];

    // Mettre à jour
    $sql = "UPDATE CategorieDepenses SET Nom = ? WHERE CategorieID = ?";
    $params = array($nom, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo 'Erreur lors de la mise à jour de la catégorie.';
    } else {
        echo 'La catégorie a été mise à jour avec succès.';
        header('location: indexC.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Catégorie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
        include "../style/header.php";

    ?>
    <div class="container">
        <h1>Modifier une Catégorie</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" name="nom" value="<?php echo $row['Nom']; ?>" class="form-control">
            </div>

            <input type="submit" name="submit" value="Enregistrer les modifications" class="btn btn-primary">
        </form>
    </div>
    <?php
        include "../style/footer.php";

    ?>
</body>
</html>