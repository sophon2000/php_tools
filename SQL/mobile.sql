SELECT
	user_name,
	REPLACE (
		SUBSTRING(
			SUBSTRING_INDEX(mobile, ',', a.id),
			CHAR - LENGTH(
				SUBSTRING_INDEX(mobile, ',', a.id - 1)
			) + 1
		),
		',',
		''
	) AS mobile
FROM
	tb_sequence a
CROSS JOIN (
	SELECT
		Uer_name,
		CONCAT(mobile, ',') AS mobile,
		LENGTH(mobile) - LENGTH(REPLACE(mobile, ',', '')) + 1 size
	FROM
		user1 b
) b ON a.id <= b.size;