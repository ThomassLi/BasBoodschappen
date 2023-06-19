<?php

if(isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen"){
		
		include_once 'classes/Leveranciers.php';
		
		$leverancier = new Leverancier;
		//$leverancier->setObject(0, $_POST['levNaam'], $_POST['levContact'], $_POST['levEmail, $_POST['levAdres'], $_POST['levPostcode'], $_POST['levWoonplaats']);
		//$leverancier->insertLeverancier();
		$leverancier->insertLeverancier2($_POST['levNaam'], $_POST['levContact'], $_POST['levEmail'], $_POST['levAdres'], $_POST['levPostcode'], $_POST['levWoonplaats']);
			
		echo "<script>alert('Leverancier: $_POST[levNaam] $_POST[levContact] $_POST[levEmail] $_POST[levAdres] $_POST[levPostcode] $_POST[levWoonplaats] is toegevoegd')</script>";
		echo "<script> location.replace('read_leverancier.php'); </script>";
			
	} 

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

	<h1>CRUD Leverancier</h1>
	<h2>Toevoegen</h2>
	<form method="post">
	<label for="kn">Leverancier naam:</label>
   <input type="text" id="ln" name="levNaam" placeholder="Leveranciernaam" required/>
   <br>   
   <label for="lc">Leverancier contactpersoon:</label>
   <input type="text" id="lc" name="levContact" placeholder="Leverancier contactpersoon" required/>
   <br> 
   <label for="le">Leverancier e-mail:</label>
   <input type="text" id="le" name="levEmail" placeholder="Leverancier e-mail" required/>
   <br>
   <label for="la">Leverancier adres:</label>
   <input type="text" id="la" name="levAdres" placeholder="Leverancier adres" required/>
   <br>   
   <label for="lp">Leverancier postcode:</label>
   <input type="text" id="lp" name="levPostcode" placeholder="Leverancier postcode" required/>
   <br>
   <label for="lw">Leverancier woonplaats:</label>
   <input type="text" id="lw" name="levWoonplaats" placeholder="Leverancier woonplaats" required/>
   <br><br>
	<input type='submit' name='insert' value='Toevoegen'>
	</form></br>

	<a href='read_leverancier.php'>Terug</a>

</body>
</html>



