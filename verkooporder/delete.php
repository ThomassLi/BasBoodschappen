<?php 

if(isset($_POST["verwijderen"])){
	include 'classes/Verkooporders.php';
	
	// Maak een object Verkooporder
	$klant = new Verkooporder;
	
	// Delete Verkooporder op basis van NR
	$klant->deleteVerkooporder($_GET["klantId"]);
	echo '<script>alert("Verkooporder verwijderd")</script>';
	echo "<script> location.replace('../read_verkooporder.php'); </script>";
}
?>



