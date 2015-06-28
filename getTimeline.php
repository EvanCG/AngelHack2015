<?php
	include 'DBVars.php';
	global $gDB_PDO_conn_string;
	global $gUsername;
	global $gPassword;
	
	try {
		$conn = new PDO($gDB_PDO_conn_string, $gUsername, $gPassword);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//$sql = "SELECT * FROM exploreuw.TOUR";

		$sql = "
			SELECT r.Round_Due AS Date_Due
				, j.Job_Title AS Title
				, c.Comp_Name AS Company
				, CASE 
					WHEN r.Round_Due <= CURDATE()
						THEN 'Follow Up'
					WHEN r.Round_Due > CURDATE()
						THEN 'Upcoming'
					END AS Action_Type
				, rt.Round_Type_Name AS Round_Type
			FROM Round r
			INNER JOIN Job j ON r.Job_Id = j.Job_Id
			INNER JOIN Company c ON j.Company_Id = c.Comp_Id
			INNER JOIN Job_Status js ON j.Job_Status_Id = js.Job_Status_Id
			INNER JOIN Round_Type rt ON r.Round_Type_Id = rt.Round_Type_Id
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
			WHERE js.Job_Stage <> 'Rejected'
			ORDER BY r.Round_Due ASC
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