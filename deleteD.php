<?php
require_once 'connexion.php';

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmation = $_POST['confirmation'];
    if ($confirmation === 'oui') {
        $sql = "DELETE FROM depense WHERE DepenseID = '$id'";
        $val = sqlsrv_query($conn, $sql);
        if ($val) {
            header('location: index.php');
        }
    } else {
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une dépense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        function confirmerSuppression() {
            return confirm("Êtes-vous sûr de vouloir supprimer cette dépense ?");
        }
    </script>
</head>
<body>

<?php
include 'style/header.php';
include 'style/footer.php';
?>
    <div class="container">
        <h1>Supprimer une dépense</h1>
        <p>Êtes-vous sûr de vouloir supprimer cette dépense ? Cette action est irréversible.</p>
        <form method="POST" onsubmit="return confirmerSuppression()">
            <input type="hidden" name="confirmation" value="oui">
            <button type="submit" class="btn btn-danger">Oui</button>
            <a href="index.php" class="btn btn-secondary">Non</a>
        </form>
    </div>
</body>
</html>