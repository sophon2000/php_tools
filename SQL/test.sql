#增加主键
ALTER TABLE `test_314` ADD COLUMN `id` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST,
 ADD PRIMARY KEY (`id`);

#drop TABLE test_314_0;
#将上下间隔小于2s的分组
CREATE TABLE test_314_0 AS SELECT
	t.*, CASE #相邻间隔小于2s分组
WHEN t.START_TIME - (
	SELECT
		t1.START_TIME
	FROM
		test_314 t1
	WHERE
		t.imsi = t1.imsi
	AND t.id > t1.id
	ORDER BY
		t1.id DESC
	LIMIT 1
) IN (0, 2000) THEN
	@i
ELSE
	(@i := @i + 1)
END AS group_num
FROM
	test_314 t,
	(SELECT @i := 1) AS i #与上一条间隔小于2s
WHERE
	t.START_TIME - (
		SELECT
			t1.START_TIME
		FROM
			test_314 t1
		WHERE
			t.imsi = t1.imsi
		AND t.id > t1.id
		ORDER BY
			t1.id DESC
		LIMIT 1
	) IN (0, 2000) #与下一条间隔小于2s
OR (
	SELECT
		t2.START_TIME
	FROM
		test_314 t2
	WHERE
		t.imsi = t2.imsi
	AND t.id < t2.id
	ORDER BY
		t2.id
	LIMIT 1
) - t.START_TIME IN (0, 2000);