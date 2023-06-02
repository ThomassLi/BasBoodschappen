<?php

include_once '../database.php';

class Klant extends Database{
	public $klantId;
	public $klantNaam;
	public $klantEmail;	
	public $klantAdres;
	public $klantPostcode;
	public $klantWoonplaats;
	
	// Methods
	
	public function setObject($klantId, $klantNaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats){
		//self::$conn = $db;
		$this->klantId = $klantId;
		$this->klantNaam = $klantNaam;
		$this->klantEmail = $klantEmail;
		$this->klantAdres = $klantAdres;
		$this->klantPostcode = $klantPostcode;
		$this->klantWoonplaats = $klantWoonplaats;
	}

		
	/**
	 * Summary of getKlanten
	 * @return mixed
	 */
	public function getKlanten(){
		// query: is een prepare en execute in 1 zonder placeholders
		$lijst = self::$conn->query("select * from 	klanten")->fetchAll();
		return $lijst;
	}

	// Get klant
	public function getKlant($klantId){

		$sql = "select * from klanten where klantId = '$klantId'";
		$query = self::$conn->prepare($sql);
		$query->execute();
		return $query->fetch();
	}
	
	public function dropDownKlant($row_selected = -1){
	
		// Haal alle klanten op uit de database mbv de method getKlanten()
		$lijst = $this->getKlanten();
		
		echo "<label for='Klanten'>Kies een klant:</label>";
		echo "<select name='klantId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["klantId"]){
				echo "<option value='$row[klantId]' selected='selected'> $row[klantNaam] $row[klantEmail]</option>\n";
			} else {
				echo "<option value='$row[klantId]'> $row[klantNaam] $row[klantEmail]</option>\n";
			}
		}
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
			$txt .=  "<td>" . $row["klantId"] . "</td>";
			$txt .=  "<td>" . $row["klantNaam"] . "</td>";
			$txt .=  "<td>" . $row["klantEmail"] . "</td>";
			$txt .=  "<td>" . $row["klantAdres"] . "</td>"; 
			$txt .=  "<td>" . $row["klantPostcode"] . "</td>"; 
			$txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update_klant.php?klantId=$row[klantId]' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";


			//Delete
			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php?klantId=$row[klantId]' >       
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";	
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	// Delete klant
 /**
  * Summary of deleteKlant
  * @param mixed $klantId
  * @return bool
  */
	public function deleteKlant($klantId){

		$sql = "delete from klanten where klantId = '$klantId'";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute();
      return ($stmt->rowCount() == 1) ? true : false;
	}

	public function updateKlant2($klantId, $naam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats){

		$sql = "update klanten 
			set klantNaam = '$naam', klantEmail = '$klantEmail', klantAdres = '$klantAdres', klantPostcode = '$klantPostcode', klantWoonplaats = '$klantWoonplaats' 
			WHERE klantId = '$klantId'";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute(); 
		return ($stmt->rowCount() == 1) ? true : false;				
	}
	
	public function updateKlantSanitized($klantId, $klantNaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats){

		$sql = "update klanten 
			set klantNaam = :klantNaam, klantEmail = :klantEmail, klantAdres = :klantAdres, klantPostcode = :klantPostcode, klantWoonplaats = :klantWoonplaats
			WHERE klantId = :klantId";
			
		// PDO sanitize automatisch in de prepare
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'klantNaam' => $klantNaam,
			'klantEmail' => $klantEmail,
			'klantAdres' => $klantAdres, 
			'klantPostcode' => $klantPostcode, 
			'klantWoonplaats' => $klantWoonplaats,
			'klantId'=> $klantId
		]);  
	}
	public function updateKlant(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		$sql = "update klanten 
		set klantNaam = :klantNaam, klantEmail = :klantEmail, klantAdres = :klantAdres, klantPostcode = :klantPostcode, klantWoonplaats = :klantWoonplaats
		WHERE klantId = :klantId";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute((array)$this);
		return ($stmt->rowCount() == 1) ? true : false;		
	}
	
	/**
	 * Summary of BepMaxklantId
	 * @return int
	 */
	private function BepMaxklantId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(klantId)+1 FROM klanten";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
	
	public function insertKlant(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		
		//
		$this->klantId = $this->BepMaxklantId();
		
		$sql = "INSERT INTO klanten (klantId, klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats)
		VALUES (:klantId, :klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";

		$stmt = self::$conn->prepare($sql);
		return $stmt->execute((array)$this);
			
	}
	
	/**
	 * Summary of insertKlant2
	 * @param mixed $klantNaam
	 * @param mixed $klantEmail
	 * @param mixed $klantAdres
	 * @param mixed $klantPostcode
	 * @param mixed $klantWoonplaats
	 * @return void
	 */
	public function insertKlant2($klantNaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats){
		
		// query
		$klantId = $this->BepMaxklantId();
		$sql = "INSERT INTO klanten (klantId, klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats)
		VALUES (:klantId, :klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";
		
		// Prepare
		$stmt = self::$conn->prepare($sql);
		
		// Execute
		$stmt->execute([
			'klantId'=>$klantId,
			'klantNaam'=>$klantNaam,
			'klantEmail'=>$klantEmail,
			'klantAdres'=>$klantAdres, 
			'klantPostcode'=>$klantPostcode, 
			'klantWoonplaats'=>$klantWoonplaats
		]);
			
	}
}
?>