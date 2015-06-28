<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	$jobId = $_POST["jobId"];
	$roundType = $_POST["roundType"];
	$dateDue = $_POST["dateDue"];
	$contact = $_POST["contact"];
	$comment = $_POST["comment"];

	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			INSERT INTO Round (Job_Id, Round_Due, Contact, Comments, Round_Type_Id)
				VALUES(
					$jobId
					, '$dateDue'
					, '$contact'
					, '$comment'
					, (SELECT Round_Type_Id FROM Round_Type WHERE Round_Type_Name = '$roundType')
				);
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