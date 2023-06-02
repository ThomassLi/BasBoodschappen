<?php

    include_once 'classes/Verkooporders.php';
    $verkooporder = new Verkooporder;

    if(isset($_POST["update"]) && $_POST["update"] == "Wijzigen"){
        $verkooporder->updateVerkooporder2($_POST['klantId'], $_POST['artId'], $_POST['verkOrdDatum'], $_POST['verkOrdBestAantal'], $_POST['verkOrdStatus'], $_POST['klantWoonplaats']);
        echo '<script>alert("Verkooporder is gewijzigd")</script>';
        
        // Toon weer het scherm
        //include "update_form.php";
    }

    if (isset($_GET['klantId'])){
        $row = $verkooporder->getVerkooporder($_GET['klantId']);
    }
?>

<!DOCTYPE html>
<html>
<body>

    <h1>CRUD Verkooporder</h1>
    <h2>Wijzigen</h2>
    <form method="post">
    <input type='text' name='klantId' value='<?php echo $row["klantId"];?>'>
    <input type='text' name='artId' required value="<?php echo $row["artId"];?>"> *</br>
    <input type='date' name='verkOrdDatum' required value='<?php echo $row["verkOrdDatum"];?>'> *</br>
    <input type='text' name='verkOrdBestAantal' required value="<?php echo $row["verkOrdBestAantal"];?>"> *</br>
    <input type='text' name='verkOrdStatus' required value='<?php echo $row["verkOrdStatus"];?>'> *</br></br> 
    <input type='submit' name='update' value='Wijzigen'>
    </form></br>

<a href='../read_verkooporder.php'>Terug</a>

</body>
</html>



