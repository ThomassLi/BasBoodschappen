<?php 

if(isset($_POST["verwijderen"])){
	include 'classes/Inkooporders.php';
	
	// Maak een object Inkooporder
	$inkooporder = new Inkooporder;
	
	// Delete Inkooporder op basis van NR
	$inkooporder->deleteInkooporder($_GET["inkooporderId"], $_GET["artId"]);
	echo '<script>alert("Inkooporder verwijderd")</script>';
	echo "<script> location.replace('../read_inkooporder.php'); </script>";
}
?>



