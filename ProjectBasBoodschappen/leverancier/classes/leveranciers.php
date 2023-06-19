<?php

include_once '../database.php';

class Leverancier extends Database{
	public $levId;
	public $levNaam;
	public $levContact;
	public $levEmail;	
	public $levAdres;
	public $levPostcode;
	public $levWoonplaats;
	
	// Methods
	
	public function setObject($levId, $levNaam, $levContact, $levEmail, $levAdres, $levPostcode, $levWoonplaats){
		//self::$conn = $db;
		$this->levId = $levId;
		$this->levNaam = $levNaam;
		$this->levContact = $levContact;
		$this->levEmail = $levEmail;
		$this->levAdres = $levAdres;
		$this->levPostcode = $levPostcode;
		$this->levWoonplaats = $levWoonplaats;
	}

		
	/**
	 * Summary of getLeveranciers
	 * @return mixed
	 */
	public function getLeveranciers(){
		// query: is een prepare en execute in 1 zonder placeholders
		$lijst = self::$conn->query("select * from 	leveranciers")->fetchAll();
		return $lijst;
	}

	// Get leverancier
	public function getLeverancier($levId){

		$sql = "select * from leveranciers where levId = '$levId'";
		$query = self::$conn->prepare($sql);
		$query->execute();
		return $query->fetch();
	}
	
	public function dropDownLeverancier($row_selected = -1){
	
		// Haal alle leveranciers op uit de database mbv de method getLeveranciers()
		$lijst = $this->getLeveranciers();
		
		echo "<label for='Leveranciers'>Kies een leverancier:</label>";
		echo "<select name='levId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["levId"]){
				echo "<option value='$row[levId]' selected='selected'> $row[levNaam] $row[levEmail]</option>\n";
			} else {
				echo "<option value='$row[levId]'> $row[levNaam] $row[levEmail]</option>\n";
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
		$txt .= "<tr>";
		$txt .= "<th>Leverancier id</th>";
		$txt .= "<th>Leverancier naam</th>";
		$txt .= "<th>Leverancier contact</th>";
		$txt .= "<th>Leverancier e-mail</th>";
		$txt .= "<th>leverancier adres</th>";
		$txt .= "<th>leverancier postcode</th>";
		$txt .= "<th>leverancier woonplaats</th>";
		$txt .= "<th>Wijzigen</th>";
		$txt .= "<th>Verwijderen</th>";
		$txt .= "</tr>";
		foreach($lijst as $row){
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["levId"] . "</td>";
			$txt .=  "<td>" . $row["levNaam"] . "</td>";
			$txt .=  "<td>" . $row["levContact"] . "</td>";
			$txt .=  "<td>" . $row["levEmail"] . "</td>";
			$txt .=  "<td>" . $row["levAdres"] . "</td>"; 
			$txt .=  "<td>" . $row["levPostcode"] . "</td>"; 
			$txt .=  "<td>" . $row["levWoonplaats"] . "</td>";
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update_leverancier.php?levId=$row[levId]' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";


			//Delete
			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php?levId=$row[levId]' >       
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";	
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	// Delete leverancier
 /**
  * Summary of deleteLeverancier
  * @param mixed $levId
  * @return bool
  */
	public function deleteLeverancier($levId){

		$sql = "delete from leveranciers where levId = '$levId'";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute();
      return ($stmt->rowCount() == 1) ? true : false;
	}

	public function updateLeverancier2($levId, $levNaam, $levContact, $levEmail, $levAdres, $levPostcode, $levWoonplaats){

		$sql = "update leveranciers 
			set levNaam = '$levNaam', levContact  = '$levContact', levEmail = '$levEmail', levAdres = '$levAdres', levPostcode = '$levPostcode', levWoonplaats = '$levWoonplaats' 
			WHERE levId = '$levId'";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute(); 
		return ($stmt->rowCount() == 1) ? true : false;				
	}
	
	public function updateLeverancierSanitized($levId, $levNaam, $levContact, $levEmail, $levAdres, $levPostcode, $levWoonplaats){

		$sql = "update leveranciers 
			set levNaam = :levNaam, levContact = :levContact, levEmail = :levEmail, levAdres = :levAdres, levPostcode = :levPostcode, levWoonplaats = :levWoonplaats
			WHERE levId = :levId";
			
		// PDO sanitize automatisch in de prepare
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'levNaam' => $levNaam,
			'levContact' => $levContact,
			'levEmail' => $levEmail,
			'levAdres' => $levAdres, 
			'levPostcode' => $levPostcode, 
			'levWoonplaats' => $levWoonplaats,
			'levId'=> $levId
		]);  
	}
	public function updateLeverancier(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		$sql = "update leveranciers 
		set levNaam = :levNaam, levContact = :levContact, levEmail = :levEmail, levAdres = :levAdres, levPostcode = :levPostcode, levWoonplaats = :levWoonplaats
		WHERE levId = :levId";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute((array)$this);
		return ($stmt->rowCount() == 1) ? true : false;		
	}
	
	/**
	 * Summary of BepMaxlevId
	 * @return int
	 */
	private function BepMaxlevId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(levId)+1 FROM leveranciers";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
	
	public function insertLeverancier(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		
		//
		$this->levId = $this->BepMaxlevId();
		
		$sql = "INSERT INTO leveranciers (levId, levNaam, levContact, levEmail, levAdres, levPostcode, levWoonplaats)
		VALUES (:levId, :levNaam, :levContact, :levEmail, :levAdres, :levPostcode, :levWoonplaats)";

		$stmt = self::$conn->prepare($sql);
		return $stmt->execute((array)$this);
			
	}
	
	/**
	 * Summary of insertLeverancier2
	 * @param mixed $levNaam
	 * @param mixed $levContact
	 * @param mixed $levEmail
	 * @param mixed $levAdres
	 * @param mixed $levPostcode
	 * @param mixed $levWoonplaats
	 * @return void
	 */
	public function insertLeverancier2($levNaam, $levContact, $levEmail, $levAdres, $levPostcode, $levWoonplaats){
		
		// query
		$levId = $this->BepMaxlevId();
		$sql = "INSERT INTO leveranciers (levId, levNaam, levContact, levEmail, levAdres, levPostcode, levWoonplaats)
		VALUES (:levId, :levNaam, :levContact, :levEmail, :levAdres, :levPostcode, :levWoonplaats)";
		
		// Prepare
		$stmt = self::$conn->prepare($sql);
		
		// Execute
		$stmt->execute([
			'levId'=>$levId,
			'levNaam'=>$levNaam,
			'levContact'=>$levContact,
			'levEmail'=>$levEmail,
			'levAdres'=>$levAdres, 
			'levPostcode'=>$levPostcode, 
			'levWoonplaats'=>$levWoonplaats
		]);
			
	}
}
?>