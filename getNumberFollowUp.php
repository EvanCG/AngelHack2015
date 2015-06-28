<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "
			SELECT
				COUNT(Job_Id) as NumFollowUps
			FROM `Job`
			INNER JOIN (
				SELECT round_id
					, Round_due
				FROM (
					SELECT *
					FROM Round
					ORDER BY Job_Id
						, Round_Due DESC
						, Round_Id
					) x
				GROUP BY Job_Id
				) mr ON r.Round_id = mr.Round_Id
			WHERE
				Job_Status_Id = 3 
				and Job_Deadline < NOW()
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