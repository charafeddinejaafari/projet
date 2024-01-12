<?php
include('Connect.php');
include('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validateForm($username, $password, $conn)) {
        session_start();
        $_SESSION['username'] = $username;
        header('Location: admin.php');
    } else {
        echo '<div id="errorMessage" class="alert alert-danger">Invalid username or password</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form method="post" action="administrateur.php" class="login-form">
                    <h3 class="mb-4 text-center">Connexion</h3>
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom et Prénom</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for "password" class="form-label">Mot De Passe</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Se Connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
