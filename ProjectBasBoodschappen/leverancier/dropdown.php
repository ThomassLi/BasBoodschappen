<html>
<body>
<h1>Dropdown Leverancier</h1>

<?php
include "classes/leveranciers.php";

// Maak een object Leverancier
$leverancier = new Leverancier;
 
?>

<form method='post'>
	<?php
		isset($_POST['kies-btn']) ? $levId=$_POST['levId'] : $levId=-1;
		$leverancier->dropDownLeverancier($levId);
	?>
	<br>
	<input type='submit' name='kies-btn' value='Kies'></input>
</form>	

<?php

if (isset($_POST['kies-btn'])){
	$leverancier->id = $_POST['levId'];
	$row = $leverancier->getLeverancier();
	
	echo "Gekozen waarde: id: $_POST[levId] $row[levNaam] $row[levContact] $row[levEmail] $row[levAdres] $row[levPostcode] $row[levWoonplaats]"; 
}
?>

</body>
</html>