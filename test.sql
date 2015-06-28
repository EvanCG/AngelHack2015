BEGIN;
INSERT INTO Job (Job_Title, Company_Id, Job_Status_Id, Job_Location)
	VALUES(
		'$jobTitle'
		, (SELECT Comp_Id FROM Company WHERE Comp_Name = '$company')
		, (SELECT Job_Status_Id FROM Job_Status WHERE Job_Stage = 'Not Started')
		, '$jobLocation'
	);
INSERT INTO Round (Job_Id, Round_Due, Contact, Comment)
	VALUES(
		LAST_INSERT_ID()
		, '$dateDue'
		, '$contact'
		, '$comment'
	);
END;