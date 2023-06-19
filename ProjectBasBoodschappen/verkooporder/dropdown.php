<html>
<body>
<h1>Dropdown Verkooporder</h1>

<?php
include "classes/verkooporders.php";

// Maak een object Verkooporder
$verkooporder = new Verkooporder;
 
?>

<form method='post'>
	<?php
		isset($_POST['kies-btn']) ? $klantId=$_POST['klantId'] : $klantId=-1;
		$verkooporder->dropDownVerkooporder($klantId);
	?>
	<br>
	<input type='submit' name='kies-btn' value='Kies'></input>
</form>	

<?php

if (isset($_POST['kies-btn'])){
	$verkooporder->id = $_POST['klantId'];
	$row = $verkooporder->getVerkooporder();
	
	echo "Gekozen waarde: id: $_POST[klantId] $row[klantNaam] $row[verkOrdDatum] $row[klantAdres] $row[klantPostcode] $row[klantWoonplaats]"; 
}
?>

</body>
</html>

