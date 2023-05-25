<?php

if(isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen"){
		
		include_once 'classes/Klanten.php';
		
		$klant = new Klant;
		//$klant->setObject(0, $_POST['klantNaam'], $_POST['klantEmail, $_POST['klantAdres'], $_POST['klantPostcode'], $_POST['klantWoonplaats']);
		//$klant->insertKlant();
		$klant->insertKlant2($_POST['klantNaam'], $_POST['klantEmail'], $_POST['klantAdres'], $_POST['klantPostcode'], $_POST['klantWoonplaats']);
			
		echo "<script>alert('Klant: $_POST[klantNaam] $_POST[klantEmail] $_POST[klantAdres] $_POST[klantPostcode] $_POST[klantWoonplaats] is toegevoegd')</script>";
		echo "<script> location.replace('index.php'); </script>";
			
	} 

?>

<!DOCTYPE html>
<html>
<body>

	<h1>CRUD Klant</h1>
	<h2>Toevoegen</h2>
	<form method="post">
	<label for="kn">Klantnaam:</label>
   <input type="text" id="kn" name="klantNaam" placeholder="Klantnaam" required/>
   <br>   
   <label for="ke">Klant e-mail:</label>
   <input type="text" id="ke" name="klantEmail" placeholder="Klant e-mail" required/>
   <br>
   <label for="ka">Klant adres:</label>
   <input type="text" id="ka" name="klantAdres" placeholder="Klant adres" required/>
   <br>   
   <label for="kp">Klant postcode:</label>
   <input type="text" id="kp" name="klantPostcode" placeholder="Klant postcode" required/>
   <br>
   <label for="kw">Klant woonplaats:</label>
   <input type="text" id="kw" name="klantWoonplaats" placeholder="Klant woonplaats" required/>
   <br><br>
	<input type='submit' name='insert' value='Toevoegen'>
	</form></br>

	<a href='read_klant.php'>Terug</a>

</body>
</html>



