<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	$jobid = $_POST["JobID"];
	$jobTitle = $_POST["jobTitle"];
	$company = $_POST["company"];
	$jobLocation = $_POST["jobLocation"];

	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			UPDATE Job
			SET 
				Job_Title='$jobTitle'
				, Company_Id=(SELECT Comp_Id FROM Company WHERE Comp_Name = '$company')
				, Job_Location='$JobLocation'
			WHERE Job_Id='$jobid';
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