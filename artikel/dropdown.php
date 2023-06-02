<html>
<body>
<h1>Dropdown Klant</h1>

<?php
include "classes/Klanten.php";

// Maak een object Klant
$klant = new Klant;
 
?>

<form method='post'>
	<?php
		isset($_POST['kies-btn']) ? $klantId=$_POST['klantId'] : $klantId=-1;
		$klant->dropDownKlant($klantId);
	?>
	<br>
	<input type='submit' name='kies-btn' value='Kies'></input>
</form>	

<?php

if (isset($_POST['kies-btn'])){
	$klant->id = $_POST['klantId'];
	$row = $klant->getKlant();
	
	echo "Gekozen waarde: id: $_POST[klantId] $row[klantNaam] $row[klantEmail] $row[klantAdres] $row[klantPostcode] $row[klantWoonplaats]"; 
}
?>

</body>
</html>