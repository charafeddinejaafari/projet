<?php

// Inclure le fichier Connect.php pour la connexion à la base de données
require_once('Connect.php');

class Utilisateur {
    private $id;
    private $nom;
    
    private $entreprise;
    private $fonction;
    private $tel;
    private $email;
    private $choix1;
    private $choix2;
    private $choix3;

    public function __construct($id, $nom, $entreprise, $fonction, $tel, $email, $choix1, $choix2, $choix3) {
        $this->id= $id;
        $this->nom = $nom;
        
        $this->entreprise = $entreprise;
        $this->fonction = $fonction;
        $this->tel = $tel;
        $this->email = $email;
        $this->choix1 = $choix1;
        $this->choix2 = $choix2;
        $this->choix3 = $choix3;
    }
    
    public function remplirFormulaire() {
        global $conn; // Assurez-vous d'avoir une connexion à la base de données

        $sql = "INSERT INTO utilisateur (nom, entreprise, fonction, tel, email, choix1, choix2, choix3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($this->nom, $this->entreprise, $this->fonction, $this->tel, $this->email, $this->choix1, $this->choix2, $this->choix3);

        $stmt->execute();
    }
}

class Admin {
    private $idAdmin;
    private $nomAdmin;
    private $motDePasse;

    public function __construct($idAdmin, $nomAdmin, $motDePasse) {
        $this->idAdmin = $idAdmin;
        $this->nomAdmin = $nomAdmin;
        $this->motDePasse = $motDePasse;
    }

    public function confirmerDate($id, $decision) {
        global $conn; // Assurez-vous d'avoir une connexion à la base de données
    
        $sql = "UPDATE utilisateur SET decision = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $decision, $id);
    
        $stmt->execute();
    }

    public function supprimerliste() {
        global $conn; // Assurez-vous d'avoir une connexion à la base de données
    
        $sql = "DELETE FROM utilisateur"; // Supprime tous les enregistrements de la table "utilisateur"
        $conn->query($sql);
    }
}

class RendezVous {
    private $idRV;
    private $dateChoisie;
    private $utilisateur;

    public function __construct($idRV, $dateChoisie, $utilisateur) {
        $this->idRV = $idRV;
        $this->dateChoisie = $dateChoisie;
        $this->utilisateur = $utilisateur;
    }
}
?>
