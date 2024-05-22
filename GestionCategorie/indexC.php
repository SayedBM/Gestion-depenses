<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories</title>
</head>
<body>
<?php
        include "../style/header.php";

    ?>
    <div class="container">
        <h1>Liste des Catégories</h1>

        <?php
        require_once '../connexion.php';

        $tsql = "SELECT * FROM CategorieDepenses";

        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo 'Erreur';
        } else {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">Identifiant</th>';
            echo '<th scope="col">Libellé</th>';
            echo '<th scope="col"><a href="addC.php" class="btn btn-success">Ajouter</a></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>'.$row['CategorieID'].'</td>';
                echo '<td>'.$row['Nom'].'</td>';
                echo '<td><a href="updateC.php?id='.$row['CategorieID'].'" class="btn btn-success">Modifier</a></td>';
                echo '<td><a href="deleteC.php?id='.$row['CategorieID'].'" class="btn btn-danger">Supprimer</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            sqlsrv_free_stmt($stmt);
        }
        ?>
    </div>
    <?php
        include "../style/footer.php";

    ?>
</body>
</html>