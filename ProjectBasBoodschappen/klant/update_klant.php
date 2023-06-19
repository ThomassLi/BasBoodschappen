<?php

    include_once 'classes/klanten.php';
    $klant = new Klant;

    if(isset($_POST["update"]) && $_POST["update"] == "Wijzigen"){
        $klant->updateKlant2($_POST['klantId'], $_POST['klantNaam'], $_POST['klantEmail'], $_POST['klantAdres'], $_POST['klantPostcode'], $_POST['klantWoonplaats']);
        echo '<script>alert("Klant is gewijzigd")</script>';
        
        // Toon weer het scherm
        //include "update_form.php";
    }

    if (isset($_GET['klantId'])){
        $row = $klant->getKlant($_GET['klantId']);
    }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

    <h1>CRUD Klant</h1>
    <h2>Wijzigen</h2>
    <form method="post">
    <input type='hidden' name='klantId' value='<?php echo $row["klantId"];?>'>
    <label>Klantnaam:</label>
    <input type='text' name='klantNaam' required value="<?php echo $row["klantNaam"];?>"> *</br>
    <label>Klant e-mail:</label>
    <input type='text' name='klantEmail' required value='<?php echo $row["klantEmail"];?>'> *</br>
    <label>Klant adres:</label>
    <input type='text' name='klantAdres' required value="<?php echo $row["klantAdres"];?>"> *</br>
    <label>Klant postcode:</label>
    <input type='text' name='klantPostcode' required value='<?php echo $row["klantPostcode"];?>'> *</br>
    <label>Klant woonplaats:</label>
    <input type='text' name='klantWoonplaats' required value='<?php echo $row["klantWoonplaats"];?>'> *</br></br> 
    <input type='submit' name='update' value='Wijzigen'>
    </form></br>

<a href='read_klant.php'>Terug</a>

</body>
</html>



