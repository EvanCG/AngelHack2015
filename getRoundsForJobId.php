<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
		$jobId = $_GET["jobid"];
	
	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			SELECT
				r.Round_Id as RoundId
				, rt.Round_Type_Name as RoundType
				, r.Contact as Contact
				, r.Comments as Comment
			FROM Round r
			JOIN Round_Type rt
			ON r.Round_Type_Id = rt.Round_Type_Id
			WHERE Job_Id = $jobId
			ORDER BY Round_Due ASC
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