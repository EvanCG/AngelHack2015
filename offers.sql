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
	o.Decision_Date DESC