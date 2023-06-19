<?php

    include_once 'classes/Leveranciers.php';
    $leverancier = new Leverancier;

    if(isset($_POST["update"]) && $_POST["update"] == "Wijzigen"){
        $leverancier->updateLeverancier2($_POST['levId'], $_POST['levNaam'], $_POST['levContact'], $_POST['levEmail'], $_POST['levAdres'], $_POST['levPostcode'], $_POST['levWoonplaats']);
        echo '<script>alert("Leverancier is gewijzigd")</script>';
        
        // Toon weer het scherm
        //include "update_form.php";
    }

    if (isset($_GET['levId'])){
        $row = $leverancier->getLeverancier($_GET['levId']);
    }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

    <h1>CRUD Leverancier</h1>
    <h2>Wijzigen</h2>
    <form method="post">
    <input type='hidden' name='levId' value='<?php echo $row["levId"];?>'>
    <label for="lc">Leverancier naam:</label>
    <input type='text' name='levNaam' required value='<?php echo $row["levNaam"];?>'> *</br>
    <label for="lc">Leverancier contactpersoon:</label>
    <input type='text' name='levContact' required value='<?php echo $row["levContact"];?>'> *</br>
    <label for="lc">Leverancier e-mail:</label>
    <input type='text' name='levEmail' required value='<?php echo $row["levEmail"];?>'> *</br>
    <label for="lc">Leverancier adres:</label>
    <input type='text' name='levAdres' required value='<?php echo $row["levAdres"];?>'> *</br>
    <label for="lc">Leverancier postcode:</label>
    <input type='text' name='levPostcode' required value='<?php echo $row["levPostcode"];?>'> *</br>
    <label for="lc">Leverancier woonplaats:</label>
    <input type='text' name='levWoonplaats' required value='<?php echo $row["levWoonplaats"];?>'> *</br></br> 
    <input type='submit' name='update' value='Wijzigen'>
    </form></br>

<a href='read_leverancier.php'>Terug</a>

</body>
</html>



