<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	$jobTitle = $_GET["jobTitle"];
	$company = $_GET["company"];
	$jobLocation = $_GET["jobLocation"];
	$dateDue = $_GET["dateDue"];
	$contact = $_GET["contact"];
	$comment = $_GET["comment"];

	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			INSERT INTO Job (Job_Title, Company_Id, Job_Status_Id, Job_Location)
				VALUES(
					'$jobTitle'
					, (SELECT Comp_Id FROM Company WHERE Comp_Name = '$company')
					, (SELECT Job_Status_Id FROM Job_Status WHERE Job_Stage = 'Not Started')
					, '$jobLocation'
				);
			INSERT INTO Round (Job_Id, Round_Due, Contact, Comments, Round_Type_Id)
				VALUES(
					LAST_INSERT_ID()
					, '$dateDue'
					, '$contact'
					, '$comment'
					, (SELECT Round_Type_Id FROM Round_Type WHERE Round_Type_Name = 'Application Drop')
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