SELECT * FROM users  AS t1  
JOIN (
	SELECT ROUND(
		RAND() * ((SELECT MAX(userId) FROM `users`)-(SELECT MIN(userId) FROM users))+(SELECT MIN(userId) FROM users)
		) AS userId
	) AS t2 
WHERE t1.userId >= t2.userId 
ORDER BY t1.userId 
LIMIT 1