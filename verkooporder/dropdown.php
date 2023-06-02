<html>
<body>
<h1>Dropdown Verkooporder</h1>

<?php
include "classes/Verkooporders.php";

// Maak een object Verkooporder
$klant = new Verkooporder;
 
?>

<form method='post'>
	<?php
		isset($_POST['kies-btn']) ? $klantId=$_POST['klantId'] : $klantId=-1;
		$klant->dropDownVerkooporder($klantId);
	?>
	<br>
	<input type='submit' name='kies-btn' value='Kies'></input>
</form>	

<?php

if (isset($_POST['kies-btn'])){
	$klant->id = $_POST['klantId'];
	$row = $klant->getVerkooporder();
	
	echo "Gekozen waarde: id: $_POST[klantId] $row[klantNaam] $row[verkOrdDatum] $row[klantAdres] $row[klantPostcode] $row[klantWoonplaats]"; 
}
?>

</body>
</html>

