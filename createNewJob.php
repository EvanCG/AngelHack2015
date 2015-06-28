<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	$jobType = $_GET["name"];
	$resume = $_GET["resume"];
	$coverLetter = $_GET["coverletter"];
	$deadline = $_GET["deadline"];
	
	$testDate = new DateTime('2014-05-04 2:30:25');
	$date = $testDate->format('Y-m-d H:i:s');
	// $date = "2016-06-06";

	$company = 'Google';
	$jobStatus = 'Waiting to Apply';

	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			INSERT INTO Job (Job_Title, Resume, Cover_Letter, Job_Deadline, Company_Id, Job_Status_Id)
			VALUES('SDE', 'Stanford', 'I want this', '$date', 2, 1)
			;";
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