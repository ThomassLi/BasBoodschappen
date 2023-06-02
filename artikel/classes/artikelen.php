<?php

include_once '../database.php';

class Artikel extends Database{
	public $artId;
	public $artOmschrijving;
	public $artInkoop;	
	public $artVerkoop;
	public $artVoorraad;
	public $artMinVoorraad;
	
	// Methods
	
	public function setObject($artId, $artOmschrijving, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad){
		//self::$conn = $db;
		$this->artId = $artId;
		$this->artOmschrijving = $artOmschrijving;
		$this->artInkoop = $artInkoop;
		$this->artVerkoop = $artVerkoop;
		$this->artVoorraad = $artVoorraad;
		$this->artMinVoorraad = $artMinVoorraad;
	}

		
	/**
	 * Summary of getArtikelen
	 * @return mixed
	 */
	public function getArtikelen(){
		// query: is een prepare en execute in 1 zonder placeholders
		$lijst = self::$conn->query("select * from 	artikelen")->fetchAll();
		return $lijst;
	}

	// Get artikel
	public function getArtikel($artId){

		$sql = "select * from artikelen where artId = '$artId'";
		$query = self::$conn->prepare($sql);
		$query->execute();
		return $query->fetch();
	}
	
	public function dropDownArtikel($row_selected = -1){
	
		// Haal alle artikelen op uit de database mbv de method getArtikelen()
		$lijst = $this->getArtikelen();
		
		echo "<label for='Artikelen'>Kies een artikel:</label>";
		echo "<select name='artId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["artId"]){		
				echo "<option value='$row[artId]' selected='selected'> $row[artOmschrijving] (&euro; $row[artVerkoop])</option>\n";
			} else {
				echo "<option value='$row[artId]'> $row[artOmschrijving] (&euro; $row[artVerkoop])</option>\n";
			}
		}
		$conn = null;
		echo "</select>";
	}

 /**
  * Summary of showTable
  * @param mixed $lijst
  * @return void
  */
	public function showTable($lijst){

		$txt = "<table border=1px>";
		foreach($lijst as $row){
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["artId"] . "</td>";
			$txt .=  "<td>" . $row["artOmschrijving"] . "</td>";
			$txt .=  "<td>" . $row["artInkoop"] . "</td>";
			$txt .=  "<td>" . $row["artVerkoop"] . "</td>"; 
			$txt .=  "<td>" . $row["artVoorraad"] . "</td>"; 
			$txt .=  "<td>" . $row["artMinVoorraad"] . "</td>";
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update_artikel.php?artId=$row[artId]' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";


			//Delete
			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php?artId=$row[artId]' >       
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";	
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	// Delete artikel
 /**
  * Summary of deleteArtikel
  * @param mixed $artId
  * @return bool
  */
	public function deleteArtikel($artId){

		$sql = "delete from artikelen where artId = '$artId'";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute();
      return ($stmt->rowCount() == 1) ? true : false;
	}

	public function updateArtikel2($artId, $naam, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad){

		$sql = "update artikelen 
			set artOmschrijving = '$naam', artInkoop = '$artInkoop', artVerkoop = '$artVerkoop', artVoorraad = '$artVoorraad', artMinVoorraad = '$artMinVoorraad' 
			WHERE artId = '$artId'";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute(); 
		return ($stmt->rowCount() == 1) ? true : false;				
	}
	
	public function updateArtikelSanitized($artId, $artOmschrijving, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad){

		$sql = "update artikelen 
			set artOmschrijving = :artOmschrijving, artInkoop = :artInkoop, artVerkoop = :artVerkoop, artVoorraad = :artVoorraad, artMinVoorraad = :artMinVoorraad
			WHERE artId = :artId";
			
		// PDO sanitize automatisch in de prepare
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'artOmschrijving' => $artOmschrijving,
			'artInkoop' => $artInkoop,
			'artVerkoop' => $artVerkoop, 
			'artVoorraad' => $artVoorraad, 
			'artMinVoorraad' => $artMinVoorraad,
			'artId'=> $artId
		]);  
	}
	public function updateArtikel(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		$sql = "update artikelen 
		set artOmschrijving = :artOmschrijving, artInkoop = :artInkoop, artVerkoop = :artVerkoop, artVoorraad = :artVoorraad, artMinVoorraad = :artMinVoorraad
		WHERE artId = :artId";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute((array)$this);
		return ($stmt->rowCount() == 1) ? true : false;		
	}
	
	/**
	 * Summary of BepMaxartikelId
	 * @return int
	 */
	private function BepMaxartikelId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(artId)+1 FROM artikelen";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
	
	public function insertArtikel(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		
		//
		$this->artId = $this->BepMaxartikelId();
		
		$sql = "INSERT INTO artikelen (artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad)
		VALUES (:artId, :artOmschrijving, :artInkoop, :artVerkoop, :artVoorraad, :artMinVoorraad)";

		$stmt = self::$conn->prepare($sql);
		return $stmt->execute((array)$this);
			
	}
	
	/**
	 * Summary of insertArtikel2
	 * @param mixed $artOmschrijving
	 * @param mixed $artInkoop
	 * @param mixed $artVerkoop
	 * @param mixed $artVoorraad
	 * @param mixed $artMinVoorraad
	 * @return void
	 */
	public function insertArtikel2($artOmschrijving, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad){
		
		// query
		$artId = $this->BepMaxartikelId();
		$sql = "INSERT INTO artikelen (artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad)
		VALUES (:artId, :artOmschrijving, :artInkoop, :artVerkoop, :artVoorraad, :artMinVoorraad)";
		
		// Prepare
		$stmt = self::$conn->prepare($sql);
		
		// Execute
		$stmt->execute([
			'artId'=>$artId,
			'artOmschrijving'=>$artOmschrijving,
			'artInkoop'=>$artInkoop,
			'artVerkoop'=>$artVerkoop, 
			'artVoorraad'=>$artVoorraad, 
			'artMinVoorraad'=>$artMinVoorraad
		]);
			
	}
}
?>