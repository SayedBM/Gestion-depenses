<?php
require_once 'connexion.php';

// Récupérer les catégories disponibles
$sqlCategories = "SELECT CategorieID, Nom FROM CategorieDepenses";
$stmtCategories = sqlsrv_query($conn, $sqlCategories);

if ($stmtCategories === false) {
    // Gérer l'erreur de requête
    die(print_r(sqlsrv_errors(), true));
}

$categories = [];
while ($row = sqlsrv_fetch_array($stmtCategories, SQLSRV_FETCH_ASSOC)) {
    $categories[] = $row;
}

// Récupérer les utilisateurs disponibles
$sqlUtilisateurs = "SELECT UtilisateurID, Nom FROM Utilisateur";
$stmtUtilisateurs = sqlsrv_query($conn, $sqlUtilisateurs);

if ($stmtUtilisateurs === false) {
    // Gérer l'erreur de requête
    die(print_r(sqlsrv_errors(), true));
}

$utilisateurs = [];
while ($row = sqlsrv_fetch_array($stmtUtilisateurs, SQLSRV_FETCH_ASSOC)) {
    $utilisateurs[] = $row;
}

// Récupérer les DepenseID non utilisés
$sqlDepenses = "SELECT DepenseID FROM depense";
$stmtDepenses = sqlsrv_query($conn, $sqlDepenses);

if ($stmtDepenses === false) {
    // Gérer l'erreur de requête
    die(print_r(sqlsrv_errors(), true));
}

$depensesUtilisees = [];
while ($row = sqlsrv_fetch_array($stmtDepenses, SQLSRV_FETCH_ASSOC)) {
    $depensesUtilisees[] = $row['DepenseID'];
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs des champs
    $depenseID = $_POST['depense_id'];
    $montant = $_POST['montant'];
    $dateDepense = $_POST['date_depense'];
    $description = $_POST['description'];
    $categorieID = $_POST['categorie_id'];
    $utilisateurID = $_POST['utilisateur_id'];

    // Préparer la requête d'insertion avec des paramètres
    $sql = "INSERT INTO depense (DepenseID, Montant, DateDepense, Description, CategorieID, UtilisateurID) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($depenseID, $montant, $dateDepense, $description, $categorieID, $utilisateurID);
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
        echo 'La dépense a été ajoutée avec succès.';
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une dépense</title>
</head>
<body>

<?php
include 'style/header.php';
include 'style/footer.php';
?>

    <h1>Ajouter une dépense</h1>
    <form method="POST">   
        <div class="form-group">
            <label for="depense_id">ID de la dépense :</label>
            <input type="text" name="depense_id" list="depense_list" class="form-control"><br>
            <datalist id="depense_list">
                <?php foreach ($depensesUtilisees as $depense) : ?>
                    <option value="<?php echo $depense; ?>">
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="form-group">
            <label for="montant">Montant :</label>
            <input type="text" name="montant" class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="date_depense">Date de dépense :</label>
            <input type="date" name="date_depense" class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" name="description" class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="categorie_id">Catégorie :</label>
            <ul>
                <?php foreach ($categories as $categorie) : ?>
                    <li>
                        <input type="radio" name="categorie_id" value="<?php echo $categorie['CategorieID']; ?>">
                        <?php echo $categorie['Nom']; ?>
                    </li>
                <?php endforeach; ?>
           </ul>
        </div>

        <div class="form-group">
            <label for="utilisateurid">Utilisateur :</label>
            <ul>
                <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <li>
                        <input type="radio" name="utilisateur_id" value="<?php echo $utilisateur['UtilisateurID']; ?>">
                        <?php echo $utilisateur['Nom']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <input type="submit" name="submit" value="Ajouter la dépense" class="btn btn-primary">
    </form>
</body>
</html>