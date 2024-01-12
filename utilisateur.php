<?php
include 'Connect.php';

mysqli_select_db($conn, 'basedata');

if (isset($_POST['submit'])) {
    // Sanitize and validate user input
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $fonction = mysqli_real_escape_string($conn, $_POST['fonction']);
    $entreprise = mysqli_real_escape_string($conn, $_POST['entreprise']);
    $objectif = mysqli_real_escape_string($conn, $_POST['objectif']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $choix1 = mysqli_real_escape_string($conn, $_POST['choix1']);
    $choix2 = mysqli_real_escape_string($conn, $_POST['choix2']);
    $choix3 = mysqli_real_escape_string($conn, $_POST['choix3']);

    // Votre requête SQL pour insérer ou mettre à jour les données
    $sql = "INSERT INTO `utilisateur` (nom, fonction, entreprise, objectif, tel, email, choix1, choix2, choix3, decision) 
            VALUES ('$nom', '$fonction', '$entreprise', '$objectif', '$tel', '$email', '$choix1', '$choix2', '$choix3', null)";
            
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: utilisateur.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <style>
        .table-container {
            margin-left: -1020px; /* Réglez la marge gauche selon vos besoins */
        }
    </style>
</head>
<body>
 
<table>

<?php

include 'Connect.php';

$sql="SELECT * FROM utilisateur";

$result = mysqli_query($conn, $sql);
//while($row = mysqli_fetch_assoc($result)){


?>
    
    <div class="table-container">
    <table border="1">
        <tr>
            <th>Nom du Client</th>
            <th>Dates Confirmées</th>
        </tr>
        <?php
        include 'Connect.php';
        $sql = "SELECT * FROM utilisateur";
        $result = mysqli_query($conn, $sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nom'] . "</td>";
            // Vérifiez si une date a été sélectionnée avant de l'afficher
            $dateDecision = $row['decision'];
            if ($dateDecision !== null) {
                echo "<td>" . date("Y-m-d h:i A", strtotime($dateDecision)) . "</td>";
            } else {
                echo "<td>En attente de confirmation</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>



<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<img src="minara.png" alt="Logo" class="logo-img">



<button id="showFormButton" class="btn btn-primary fixed-top-start">+</button>



<form method="post" id="reservationForm" class="p-4 shadow-lg rounded bg-white" style="display: none;">
  <div class="mb-3">
    <h1>Formulaire</h1>
    <label for="name" class="form-label">Nom et Prénom</label>
    <input type="text" name="nom" class="form-control" id="nom" required>
  </div>
  <div class="mb-3">
    <label for="entreprise" class="form-label">Entreprise</label>
    <input type="text" name="entreprise" class="form-control" id="entreprise" required>
</div>
<div class="mb-3">
    <label for="fonction" class="form-label">Fonction</label>
    <input type="text" name="fonction" class="form-control" id="fonction" required>
</div>

  <div class="mb-3">
    <label for="objectif" class="form-label">Objectif</label>
    <select name="objectif" class="form-select" id="objectif" required>
      <option value="visite">Visite</option>
      <option value="achats">Achats</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="phone" class="form-label">Tel</label>
    <input type="text" name="tel" class="form-control" id="tel" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email </label>
    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="possibilite" class="form-label">Possibilité</label>
    <br>
    <label for="choix1" class="form-label">Choix 1 - Date et Heure</label>
    <input type="datetime-local" name="choix1" class="form-control" id="choix1" required>
    
    <label for="choix2" class="form-label">Choix 2 - Date et Heure</label>
    <input type="datetime-local" name="choix2" class="form-control" id="choix2" required>
    
    <label for="choix3" class="form-label">Choix 3 - Date et Heure</label>
    <input type="datetime-local" name="choix3" class="form-control" id="choix3" required>
  </div>

  <div class="text-center"> <!-- Add a container with text-center class -->
    <button type="submit" name="submit" class="btn btn-primary">Confirmer</button>
  </div>
</form>
<style>
  
</style>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script>
  const showFormButton = document.getElementById("showFormButton");
  const reservationForm = document.getElementById("reservationForm");
  let isFormVisible = false;

  showFormButton.addEventListener("click", () => {
    if (isFormVisible) {
      reservationForm.style.display = "none";
      showFormButton.textContent = "+";
      showFormButton.classList.remove("fixed-top-end"); 
    } else {
      reservationForm.style.display = "block";
      showFormButton.textContent = "-";
      showFormButton.classList.add("fixed-top-end"); 
    }
    isFormVisible = !isFormVisible;
  });
</script>
<style>
.fixed-top-start {
    position: fixed;
    top: 180px; /* Utilisez une valeur positive pour déplacer le bouton vers le bas */
    right:  300px;
    z-index: 1000;
}
.fixed-top-end {
    position: fixed;
    top: 200px; /* Utilisez une valeur positive pour déplacer le bouton vers le bas */
    right:  420px;
    z-index: 1000;
}





  .text-center {
    text-align: center;
  }

  
  .logo-img {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 200px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
    z-index: 1000;
  }
  body {
    background-image: url("menara.png"); /* Replace with your image path */
    background-size: cover; /* Adjust the background size */
    background-repeat: no-repeat;
    background-position: center center;
  }
  table {
    border-collapse: collapse;
    width: 50%;
    margin: 0 auto; /* Centre le tableau horizontalement */
}

table, th, td {
    border: 1px solid black;
}

/* Ajouter cette règle pour définir une largeur fixe pour les cellules du tableau */
/* Set the background color to red */
th, td {
    border: 1px solid black;
    width: 100px;
    padding: 10px;
    text-align: center;
    background-color: red; /* Set the background color to red */
}



/* Changement de couleur au survol */

</style>

</body>
</html>