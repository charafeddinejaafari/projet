<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: administrateur.php');
    exit();
}

include('Connect.php');

if(isset($_POST['idd']) && isset($_POST['selected_choice'])){
    $id = $_POST['idd'];
    $choice = $_POST['selected_choice'];

    // Utilisez une requête préparée pour éviter les injections SQL
    $sql = "UPDATE utilisateur
            SET decision = ?
            WHERE id = ?";
    
    // Préparez la requête
    $stmt = mysqli_prepare($conn, $sql);

    // Liez les paramètres
    mysqli_stmt_bind_param($stmt, "si", $choice, $id);

    // Exécutez la requête
    if (mysqli_stmt_execute($stmt)) {
        // Redirigez l'utilisateur vers la page admin.php après la mise à jour réussie
        header("location: admin.php");
    } else {
        // En cas d'erreur, affichez un message d'erreur
        echo "Erreur lors de la mise à jour de la décision : " . mysqli_error($conn);
    }

    // Fermez la requête préparée
    mysqli_stmt_close($stmt);
} 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php
    
    $servername = "localhost"; // Your database server name
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $database_name = "basedata"; // Your database name

    $conn = mysqli_connect($servername, $username, $password, $database_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Define and initialize $showTable
    $showTable = true;if ($showTable) : ?>
        <div class="container my-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id_Client</th>
                        <th scope="col">Nom_Client</th>
                        <th scope="col">Entreprise</th>
                        <th scope="col">Objectif</th>
                        <th scope="col">Choix1</th>
                        <th scope="col">Choix2</th>
                        <th scope="col">Choix3</th>
                        <th scope="col">Décision</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connexion à la base de données et récupération des données
                    $database_name = "basedata"; // Remplacez par le nom réel de votre base de données
                    if (!mysqli_select_db($conn, $database_name)) {
                        die("Impossible de sélectionner la base de données : " . mysqli_error($conn));
                    }

                    $sql = "SELECT * FROM utilisateur";
                    $result = mysqli_query($conn, $sql);

                   


if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr id="row-' . $row['id'] . '">
        <td>' . $row['id'] . '</td>
        <td>' . $row['nom'] . '</td>
        <td>' . $row['entreprise'] . '</td>
        <td>' . $row['objectif'] . '</td>
        <td>' . date("Y-m-d", strtotime($row['choix1'])) . '<br>' . date("h:i A", strtotime($row['choix1'])) . '</td>
        <td>' . date("Y-m-d", strtotime($row['choix2'])) . '<br>' . date("h:i A", strtotime($row['choix2'])) . '</td>
        <td>' . date("Y-m-d", strtotime($row['choix3'])) . '<br>' . date("h:i A", strtotime($row['choix3'])) . '</td>
        <td>' . ($row['decision'] ? date("Y-m-d", strtotime($row['decision'])) . '<br>' . date("h:i A", strtotime($row['decision'])) : '') . '</td>
        <td>
        <form method="post" action="">

            <input type="hidden" name="idd" value="' . $row['id'] . '">
            <!-- Ajouter un champ caché pour stocker le choix confirmé -->
            <input type="hidden" name="confirmed_choice" id="confirmed_choice">
            <select class="form-select" name="selected_choice" onchange="updateConfirmedChoice(this)">
                <option value="'.$row['choix1'].'">Choix1</option>
                <option value="'.$row['choix2'].'">Choix2</option>
                <option value="'.$row['choix3'].'">Choix3</option>
            </select>
            <button type="submit" class="btn btn-primary" name="confirm">Confirmer</button>
        </form>
        

        <a href="Supprimer.php?deleteid=' . $row['id'] . '" class="btn btn-danger" >Supprimer</a>
    </td>

    </tr>';



    }
}


                      
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <script>
    function updateConfirmedChoice(selectElement) {
        document.getElementById('confirmed_choice').value = selectElement.value;
    }
</script>



</body>
</html>