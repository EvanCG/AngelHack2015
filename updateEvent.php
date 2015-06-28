<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	$roundId = $_GET["roundId"];
	$roundType = $_GET["roundType"];
	$dateDue = $_GET["dateDue"];
	$contact = $_GET["contact"];
	$comment = $_GET["comment"];

	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			UPDATE Round
			SET 
				Round_Due='$dateDue'
				, Contact='$contact'
				, Comments='$comment'
				, Round_Type_Id=(SELECT Round_Type_Id FROM Round_Type WHERE Round_Type_Name = '$roundType')
			WHERE Round_Id='$roundId';
		";
		$query = $conn->prepare($sql);
		$query->execute();

		$result = $query->fetchall(PDO::FETCH_ASSOC);
		if (count($result)) {
			$return_array = array();
			foreach($result as $row) {
				array_push($return_array, $row);
			}
			echo json_encode($return_array);
		} else {
			echo json_encode();
		}
	} catch (PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
	
?>