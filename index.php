<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des dépenses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <?php
    include('style/header.php');

    echo '<h1>Liste des dépenses</h1>';
    require_once 'connexion.php';
    echo 'OKAY';
    $tsql = "SELECT d.DepenseID, d.Montant, d.DateDepense, d.Description, u.Nom, c.Nom as nomC
             FROM depense d
             JOIN Utilisateur u ON d.UtilisateurID = u.UtilisateurID
             JOIN CategorieDepenses c ON d.CategorieID = c.CategorieID";

    $stmt = sqlsrv_query($conn, $tsql);

    if ($stmt === false) {
        echo 'Erreur';
    } else {
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>DepenseID</th>';
        echo '<th>Montant</th>';
        echo '<th>DateDepense</th>';
        echo '<th>Description</th>';
        echo '<th>Utilisateur</th>';
        echo '<th>Catégorie</th>';
        echo '<th>Modifier</th>';
        echo '<th>Supprimer</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>'.$row['DepenseID'].'</td>';
            echo '<td>'.$row['Montant'].'</td>';
            echo '<td>'.$row['DateDepense']->format('Y-m-d').'</td>';
            echo '<td>'.$row['Description'].'</td>';
            echo '<td>'.$row['Nom'].'</td>';
            echo '<td>'.$row['nomC'].'</td>';
            echo '<td><a href="updateD.php?id='.$row['DepenseID'].'" class="btn btn-primary"">Modifier</a></td>';
            echo '<td><a href="deleteD.php?id='.$row['DepenseID'].'" class="btn btn-danger">Supprimer</a> </td>';
            
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<td><a href="addD.php" class="btn btn-success">Ajouter</a></td>';

        sqlsrv_free_stmt($stmt);
    }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
include('style/footer.php');
?>
</body>
</html>