<?php
include 'Connect.php';
if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM utilisateur WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        //echo "Deleted successfully";

        header("location:admin.php");
    } else {
        $errorMessage = "La suppression a échoué. Veuillez réessayer plus tard.";
        echo $errorMessage;
    }
    
    
}

?>

