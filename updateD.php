<?php
require_once 'connexion.php';

$id = (int)$_GET['id'];

// Récupérer les données existantes
$sql = "SELECT * FROM depense WHERE DepenseID = ?";
$params = array($id);
$stmt = sqlsrv_query($conn, $sql, $params);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles valeurs des champs
    $montant = $_POST['montant'];
    $dateDepense = $_POST['date_depense'];
    $description = $_POST['description'];

    // Mettre à jour les champs dans la base de données
    $sql = "UPDATE depense SET Montant = ?, DateDepense = ?, Description = ? WHERE DepenseID = ?";
    $params = array($montant, $dateDepense, $description, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo 'Erreur lors de la mise à jour de la dépense.';
    } else {
        echo 'La dépense a été mise à jour avec succès.';
        header('location: index.php');
    }
    include("style/header.php");
    include('style/footer.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une dépense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
     include("style/header.php");
     include('style/footer.php');
    ?>
    <div class="container">
        <h1>Modifier une dépense</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="montant" class="form-label">Montant :</label>
                <input type="text" name="montant" class="form-control" value="<?php echo $row['Montant']; ?>">
            </div>

            <div class="mb-3">
                <label for="date_depense" class="form-label">Date de dépense :</label>
                <input type="text" name="date_depense" class="form-control" value="<?php echo $row['DateDepense']->format('Y-m-d'); ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <input type="text" name="description" class="form-control" value="<?php echo $row['Description']; ?>">
            </div>

            <input type="submit" name="submit" value="Enregistrer les modifications" class="btn btn-primary">
        </form>
    </div>
</body>
</html>