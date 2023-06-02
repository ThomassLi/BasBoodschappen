<?php

include_once '../database.php';

class Verkooporder extends Database{
	public $klantId;
	public $artId;
	public $verkOrdDatum;	
	public $verkOrdBestAantal;
	public $verkOrdStatus;
	
	// Methods
	
	public function setObject($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus){
		//self::$conn = $db;
		$this->klantId = $klantId;
		$this->artId = $artId;
		$this->verkOrdDatum = $verkOrdDatum;
		$this->verkOrdBestAantal = $verkOrdBestAantal;
		$this->verkOrdStatus = $verkOrdStatus;
	}

		
	/**
	 * Summary of getVerkooporders
	 * @return mixed
	 */
	public function getVerkooporders(){
		// query: is een prepare en execute in 1 zonder placeholders
		$lijst = self::$conn->query("select * from 	verkooporders")->fetchAll();
		return $lijst;
	}

	// Get klant en artikel
	public function getVerkooporder($klantId, $artId){
		$sql = "SELECT * FROM verkooporders WHERE klantId = :klantId AND artId = :artId";
		$query = self::$conn->prepare($sql);
		$query->bindParam(':klantId', $klantId);
		$query->bindParam(':artId', $artId);
		$query->execute();
		return $query->fetch();
	}
	
	

	public function dropDownVerkooporder($row_selected = -1){
		// ...
		echo "<select name='klantId'>"; // Separate attributes for klantId and artId
		foreach ($lijst as $row){
			if($row_selected == $row["klantId"]){
				echo "<option value='$row[klantId] $row[artId]' selected='selected'> $row[verkOrdDatum] $row[verkOrdBestAantal] $row[verkOrdStatus]</option>\n";
			} else {
				echo "<option value='$row[klantId] $row[artId]'>  $row[verkOrdDatum] $row[verkOrdBestAantal] $row[verkOrdStatus]</option>\n";
			}
		}
		echo "</select>";
		// ...
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
			$txt .=  "<td>" . $row["artId"] . "</td>";
			$txt .=  "<td>" . $row["verkOrdDatum"] . "</td>";
			$txt .=  "<td>" . $row["verkOrdBestAantal"] . "</td>"; 
			$txt .=  "<td>" . $row["verkOrdStatus"] . "</td>"; 
			
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
	

	// Delete klant en artikel
 /**
  * Summary of deleteVerkooporder
  * @param mixed $klantId
  * @param mixed $artId
  * @return bool
  */
	public function deleteVerkooporder($klantId, $artId){
		$sql = "DELETE FROM verkooporders WHERE klantId = :klantId AND artId = :artId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute(['klantId' => $klantId, 'artId' => $artId]);
		return ($stmt->rowCount() == 1) ? true : false;
	}
	

	public function updateVerkooporder2($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus){
		$sql = "UPDATE verkooporders 
				SET verkOrdDatum = :verkOrdDatum, verkOrdBestAantal = :verkOrdBestAantal, verkOrdStatus = :verkOrdStatus 
				WHERE klantId = :klantId AND artId = :artId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'klantId' => $klantId,
			'artId' => $artId,
			'verkOrdDatum' => $verkOrdDatum,
			'verkOrdBestAantal' => $verkOrdBestAantal,
			'verkOrdStatus' => $verkOrdStatus
		]);
		return ($stmt->rowCount() == 1) ? true : false;
	}
	
	
	public function updateVerkooporderSanitized($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus){

		$sql = "update verkooporders 
			set verkOrdDatum = :verkOrdDatum, verkOrdBestAantal = :verkOrdBestAantal, verkOrdStatus = :verkOrdStatus 
			WHERE klantId = :klantId, artId = :artId";
			
		// PDO sanitize automatisch in de prepare
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'artId' => $artId,
			'verkOrdDatum' => $verkOrdDatum,
			'verkOrdBestAantal' => $verkOrdBestAantal, 
			'verkOrdStatus' => $verkOrdStatus, 
			'klantId'=> $klantId
		]);  
	}
	public function updateVerkooporder(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		$sql = "update verkooporders 
		set verkOrdDatum = :verkOrdDatum, verkOrdBestAantal = :verkOrdBestAantal, verkOrdStatus = :verkOrdStatus
		WHERE klantId = :klantId, artId = :artId";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute((array)$this);
		return ($stmt->rowCount() == 1) ? true : false;		
	}
	
	/**
	 * Summary of BepMaxklantId
	 * @return int
	 */
	/*
	private function BepMaxklantId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(klantId)+1 FROM verkooporders";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
*/
	
	public function insertVerkooporder(){
		$this->klantId = $this->BepMaxklantId(); // Remove this line if not needed
		$sql = "INSERT INTO verkooporders (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus)
				VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus )";
		$stmt = self::$conn->prepare($sql);
		return $stmt->execute((array)$this);
	}
	
	
	/**
	 * Summary of insertVerkooporder2
	 * @param mixed $verkOrdDatum
	 * @param mixed $verkOrdBestAantal
	 * @param mixed $verkOrdStatus
	 * @return void
	 */
	/*
	public function insertVerkooporder2($verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus){
		
		// query
		$klantId = $this->BepMaxklantId();
		$sql = "INSERT INTO verkooporders (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus)
		VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus)";
			
		// Prepare
		$stmt = self::$conn->prepare($sql);
		
		// Execute
		$stmt->execute([
			'klantId'=>$klantId,
			'artId'=>$artId,
			'verkOrdDatum'=>$verkOrdDatum,
			'verkOrdBestAantal'=>$verkOrdBestAantal, 
			'verkOrdStatus'=>$verkOrdStatus
		]);
			
	}*/
	

	public function insertVerkooporder2($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus){

		// query
		$sql = "INSERT INTO verkooporders (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus)
				VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus)";
	
		// Prepare
		$stmt = self::$conn->prepare($sql);

		// Execute
		$stmt->execute([
			'klantId' => $klantId,
			'artId' => $artId,
			'verkOrdDatum' => $verkOrdDatum,
			'verkOrdBestAantal' => $verkOrdBestAantal,
			'verkOrdStatus' => $verkOrdStatus
		]);
	}
	
}
?>

