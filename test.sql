SELECT
	r.Round_Due as Date
	, j.Job_Title as Title
	, c.Comp_Name as Company
	, CASE
		WHEN r.Round_Due <= CURDATE() THEN 'Follow Up'
		WHEN r.Round_Due > CURDATE() THEN 'Upcoming'
	END as Action_Type
	, rt.Round_Type_Name as Round_Type
FROM Round r
JOIN Job j
ON r.Job_Id = j.Job_Id
JOIN Company c
ON j.Company_Id = c.Comp_Id
JOIN Job_Status js
ON j.Job_Status_Id = js.Job_Status_Id
JOIN Round_Type rt
ON r.Round_Type_Id = rt.Round_Type_Id
WHERE
	js.Job_Stage <> 'Rejected'
	AND r.Round_Id in (SELECT Round_Id WHERE  )
ORDER BY
	r.Round_Due ASC