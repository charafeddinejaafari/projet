<?php
$servername = "localhost"; // Remplacez par votre nom de serveur
$username = "root"; // Remplacez par votre nom d'utilisateur de la base de données
$password = ""; // Remplacez par votre mot de passe de la base de données
$dbname = "basedata"; // Remplacez par le nom de votre base de données

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
