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
				j.Job_Title as Job_Title
				, c.Comp_Name as Company
				, o.Decision_Date as Deadline
				, o.Salary as Salary
				, o.Stock as Stock
				, o.Bonus as Bonus
				, j.Job_Location as Location
			FROM Job j
			JOIN Company c
			ON j.Company_Id = c.Comp_Id
			JOIN Offer o
			ON j.Job_id = o.Job_Id
			ORDER BY
				o.Decision_Date ASC
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