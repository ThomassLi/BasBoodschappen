<?php

include_once '../database.php';

class Inkooporder extends Database{
	public $levId;
	public $artId;
	public $inkOrdDatum;	
	public $inkOrdBestAantal;
	public $inkOrdStatus;
	
	// Methods
	
	public function setObject($levId, $artId, $inkOrdDatum, $inkOrdBestAantal, $inkOrdStatus){
		//self::$conn = $db;
		$this->levId = $levId;
		$this->artId = $artId;
		$this->inkOrdDatum = $inkOrdDatum;
		$this->inkOrdBestAantal = $inkOrdBestAantal;
		$this->inkOrdStatus = $inkOrdStatus;
	}

		
	/**
	 * Summary of getInkooporders
	 * @return mixed
	 */
	public function getInkooporders(){
		// query: is een prepare en execute in 1 zonder placeholders
		$lijst = self::$conn->query("select * from 	inkooporders")->fetchAll();
		return $lijst;
	}

	// Get leverancier en artikel
	public function getInkooporder($levId, $artId){
		$sql = "SELECT * FROM inkooporders WHERE levId = :levId AND artId = :artId";
		$query = self::$conn->prepare($sql);
		$query->bindParam(':levId', $levId);
		$query->bindParam(':artId', $artId);
		$query->execute();
		return $query->fetch();
	}
	
	

	public function dropDownInkooporder($row_selected = -1){
		// ...
		echo "<select name='levId'>"; // Separate attributes for levId and artId
		foreach ($lijst as $row){
			if($row_selected == $row["levId"]){
				echo "<option value='$row[levId] $row[artId]' selected='selected'> $row[inkOrdDatum] $row[inkOrdBestAantal] $row[inkOrdStatus]</option>\n";
			} else {
				echo "<option value='$row[levId] $row[artId]'>  $row[inkOrdDatum] $row[inkOrdBestAantal] $row[inkOrdStatus]</option>\n";
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
			$txt .=  "<td>" . $row["levId"] . "</td>";
			$txt .=  "<td>" . $row["artId"] . "</td>";
			$txt .=  "<td>" . $row["inkOrdDatum"] . "</td>";
			$txt .=  "<td>" . $row["inkOrdBestAantal"] . "</td>"; 
			$txt .=  "<td>" . $row["inkOrdStatus"] . "</td>"; 
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update_inkooporder.php?artId=$row[artId]' >       
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
	

	// Delete leverancier en artikel
 /**
  * Summary of deleteInkooporder
  * @param mixed $levId
  * @param mixed $artId
  * @return bool
  */
	public function deleteInkooporder($levId, $artId){
		$sql = "DELETE FROM inkooporders WHERE levId = :levId AND artId = :artId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute(['levId' => $levId, 'artId' => $artId]);
		return ($stmt->rowCount() == 1) ? true : false;
	}
	

	public function updateInkooporder2($levId, $artId, $inkOrdDatum, $inkOrdBestAantal, $inkOrdStatus){
		$sql = "UPDATE inkooporders 
				SET inkOrdDatum = :inkOrdDatum, inkOrdBestAantal = :inkOrdBestAantal, inkOrdStatus = :inkOrdStatus 
				WHERE levId = :levId AND artId = :artId";
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'levId' => $levId,
			'artId' => $artId,
			'inkOrdDatum' => $inkOrdDatum,
			'inkOrdBestAantal' => $inkOrdBestAantal,
			'inkOrdStatus' => $inkOrdStatus
		]);
		return ($stmt->rowCount() == 1) ? true : false;
	}
	
	
	public function updateInkooporderSanitized($levId, $artId, $inkOrdDatum, $inkOrdBestAantal, $inkOrdStatus){

		$sql = "update inkooporders 
			set inkOrdDatum = :inkOrdDatum, inkOrdBestAantal = :inkOrdBestAantal, inkOrdStatus = :inkOrdStatus 
			WHERE levId = :levId, artId = :artId";
			
		// PDO sanitize automatisch in de prepare
		$stmt = self::$conn->prepare($sql);
		$stmt->execute([
			'artId' => $artId,
			'inkOrdDatum' => $inkOrdDatum,
			'inkOrdBestAantal' => $inkOrdBestAantal, 
			'inkOrdStatus' => $inkOrdStatus, 
			'levId'=> $levId
		]);  
	}
	public function updateInkooporder(){
		// Voor deze functie moet eerst een setObject aangeroepen worden om $this te vullen
		$sql = "update inkooporders 
		set inkOrdDatum = :inkOrdDatum, inkOrdBestAantal = :inkOrdBestAantal, inkOrdStatus = :inkOrdStatus
		WHERE levId = :levId, artId = :artId";

		$stmt = self::$conn->prepare($sql);
		$stmt->execute((array)$this);
		return ($stmt->rowCount() == 1) ? true : false;		
	}
	
	/**
	 * Summary of BepMaxlevId
	 * @return int
	 */
	/*
	private function BepMaxlevId() : int {
		
	// Bepaal uniek nummer
	$sql="SELECT MAX(levId)+1 FROM inkooporders";
	return  (int) self::$conn->query($sql)->fetchColumn();
}
*/
	
	public function insertInkooporder(){
		$this->levId = $this->BepMaxlevId(); // Remove this line if not needed
		$sql = "INSERT INTO inkooporders (levId, artId, inkOrdDatum, inkOrdBestAantal, inkOrdStatus)
				VALUES (:levId, :artId, :inkOrdDatum, :inkOrdBestAantal, :inkOrdStatus )";
		$stmt = self::$conn->prepare($sql);
		return $stmt->execute((array)$this);
	}
	
	
	/**
	 * Summary of insertInkooporder2
	 * @param mixed $inkOrdDatum
	 * @param mixed $inkOrdBestAantal
	 * @param mixed $inkOrdStatus
	 * @return void
	 */
	/*
	public function insertInkooporder2($inkOrdDatum, $inkOrdBestAantal, $inkOrdStatus){
		
		// query
		//$levId = $this->BepMaxlevId();
		$sql = "INSERT INTO inkooporders (levId, artId, inkOrdDatum, inkOrdBestAantal, inkOrdStatus)
		VALUES (:levId, :artId, :inkOrdDatum, :inkOrdBestAantal, :inkOrdStatus)";
			
		// Prepare
		$stmt = self::$conn->prepare($sql);
		
		// Execute
		$stmt->execute([
			'levId'=>$levId,
			'artId'=>$artId,
			'inkOrdDatum'=>$inkOrdDatum,
			'inkOrdBestAantal'=>$inkOrdBestAantal, 
			'inkOrdStatus'=>$inkOrdStatus
		]);
			
	}
	*/
	
	public function insertInkooporder2($levId, $artId, $inkOrdDatum, $inkOrdBestAantal, $inkOrdStatus){

		// query
		$sql = "INSERT INTO inkooporders (levId, artId, inkOrdDatum, inkOrdBestAantal, inkOrdStatus)
				VALUES (:levId, :artId, :inkOrdDatum, :inkOrdBestAantal, :inkOrdStatus)";
	
		// Prepare
		$stmt = self::$conn->prepare($sql);

		// Execute
		$stmt->execute([
			'levId' => $levId,
			'artId' => $artId,
			'inkOrdDatum' => $inkOrdDatum,
			'inkOrdBestAantal' => $inkOrdBestAantal,
			'inkOrdStatus' => $inkOrdStatus
		]);
	}
	
}
?>

