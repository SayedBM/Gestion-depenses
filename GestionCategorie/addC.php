<?php
require_once '../connexion.php';

$sqlC = "SELECT CategorieID, Nom FROM CategorieDepenses";

$stmtC = sqlsrv_query($conn, $sqlC);

// En cas d'erreur
if ($stmtC === false) {
    die(print_r(sqlsrv_errors(), true));
}

$idCUtilisees = [];
while ($row = sqlsrv_fetch_array($stmtC, SQLSRV_FETCH_ASSOC)) {
    $idCUtilisees[] = $row['CategorieID'];
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs
    $categorieID = $_POST['categorie_id'];
    $nomC = $_POST['nom'];

    $sql = "INSERT INTO CategorieDepenses (CategorieID, Nom) VALUES (?, ?)";
    $params = array($categorieID, $nomC);

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
        echo 'La catégorie a été ajoutée avec succès.';
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
    <title>Ajouter Catégorie</title>
</head>
<body>
    <?php
        include "../style/header.php";

    ?>
    <div class="container">
        <h1>Ajouter Catégorie</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="categorie_id" class="form-label">Identifiant :</label>
                <input type="text" name="categorie_id" list="categorie_list" class="form-control">
                <datalist id="categorie_list">
                    <?php foreach ($idCUtilisees as $cat) : ?>
                        <option value="<?php echo $cat; ?>">
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" name="nom" class="form-control">
            </div>

            <input type="submit" name="submit" value="Ajouter catégorie" class="btn btn-primary">
        </form>
    </div>
    <?php
            include "../style/footer.php";
    ?>
    include
</body>
</html>