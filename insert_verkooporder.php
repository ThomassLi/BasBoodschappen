<?php

		include "../klant/classes/Klanten.php";
		include "../artikel/classes/Artikelen.php";

		// Maak een object Klant
		$klant = new Klant;

		// Maak een object Artikel
		$artikel = new Artikel;

	if(isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen"){
		
		include_once 'classes/Verkooporders.php';
		
		$verkooporder = new Verkooporder;
		//$verkooporder->setObject(0, $_POST['klantId'], $_POST['artId, $_POST['verkOrdDatum'], $_POST['verkOrdBestAantal'], $_POST['verkOrdStatus']);
		//$verkooporder->insertVerkooporder();
		$verkooporder->insertVerkooporder2($_POST['klantId'], $_POST['artId'], $_POST['verkOrdDatum'], $_POST['verkOrdBestAantal'], $_POST['verkOrdStatus']);
			
		echo "<script>alert('Verkooporder: $_POST[klantId] $_POST[artId] $_POST[verkOrdDatum] $_POST[verkOrdBestAantal] $_POST[verkOrdStatus] is toegevoegd')</script>";
		echo "<script> location.replace('../read_klant.php'); </script>";
			
	} 

?>

<!DOCTYPE html>
<html>
<body>

	<h1>CRUD Verkooporder</h1>
	<h2>Toevoegen</h2>
	<form method="post">
	<?php
		isset($_POST['Toevoegen']) ? $klantId=$_POST['klantId'] : $klantId=-1;
		$klant->dropDownKlant($klantId);
		echo "<br>";
		isset($_POST['Toevoegen']) ? $klantId=$_POST['artId'] : $artId=-1;
		$artikel->dropDownArtikel($artId);

	?>
   <br>   
   <label for="vod">Verkoop order datum:</label>
   <input type="date" id="vod" name="verkOrdDatum" placeholder="Verkoop order datum" required/>
   <br>   
   <label for="voba">Verkoop order besteld aantal:</label>
   <input type="number" id="voba" name="verkOrdBestAantal" placeholder="Verkoop order besteld aantal" required/>
   <br>
   <label for="vos">Kies verkoop order status:</label>
   <select id="vos" name="verkOrdStatus">
		<option value="1">1: Genoteerd in tabel.</option>
		<option value="2">2: Magazijnmedewerker verzamelt het artikel.</option>
		<option value="3">3: Tas met artikel is bij de bezorger.</option>
		<option value="4">4: Tas met artikel is afgeleverd bij de klant.</option>
    </select>  
   <br><br>
	<input type='submit' name='insert' value='Toevoegen'>
	</form></br>

	<a href='../read_klant.php'>Terug</a>

</body>
</html>

<?php

if (isset($_POST['Toevoegen'])){
	$verkooporder->id = $_POST['klantId'];
	$row = $verkooporder->getVerkooporder();
	
	//echo "Gekozen waarde: id: $_POST[klantId] $row[klantNaam] $row[klantEmail] $row[klantAdres] $row[klantPostcode] $row[klantWoonplaats]"; 
}

if (isset($_POST['Toevoegen'])){
	$verkooporder->id = $_POST['artId'];
	$row = $verkooporder->getVerkooporder();
	
	//echo "Gekozen waarde: id: $_POST[artId] $row[klantNaam] $row[klantEmail] $row[klantAdres] $row[klantPostcode] $row[klantWoonplaats]"; 
}

?>