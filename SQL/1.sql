SELECT
	eck_delivery_schedule.id AS id,
	eck_delivery_schedule.title AS eck_delivery_schedule_title,
	eck_delivery_schedule.created AS eck_delivery_schedule_created,
	'delivery_schedule' AS field_data_field_delivery_id_delivery_schedule_entity_type,
	'delivery_schedule' AS field_data_field_delivery_type_delivery_schedule_entity_type,
	'delivery_schedule' AS field_data_field_organization_delivery_schedule_entity_type,
	'delivery_schedule' AS field_data_field_delivery_date_delivery_schedule_entity_type,
	'delivery_schedule' AS field_data_field_distribution_route_ref_delivery_schedule_en
FROM
	{ eck_delivery_schedule } eck_delivery_schedule
WHERE
	(
		(
			(
				eck_delivery_schedule.type IN ('delivery_schedule')
			)
		)
	)
ORDER BY
	eck_delivery_schedule_created DESC
LIMIT 30 OFFSET 0


SELECT
	field_data_field_delivery_date.delta AS field_data_field_delivery_date_delta,
	field_data_field_delivery_date.entity_id AS date_id_field_delivery_date,
	field_data_field_delivery_date.delta AS date_delta_field_delivery_date,
	eck_delivery_schedule.id AS id,
	field_data_field_delivery_date. LANGUAGE AS field_data_field_delivery_date_language,
	field_data_field_delivery_date.bundle AS field_data_field_delivery_date_bundle,
	field_data_field_delivery_date.field_delivery_date_value AS field_data_field_delivery_date_field_delivery_date_value,
	field_data_field_delivery_date.field_delivery_date_rrule AS field_data_field_delivery_date_field_delivery_date_rrule,
	'delivery_schedule' AS field_data_field_delivery_type_delivery_schedule_entity_type,
	'delivery_schedule' AS field_data_field_delivery_date_offset_delivery_schedule_enti,
	'delivery_schedule' AS field_data_field_delivery_date_delivery_schedule_entity_type
FROM
	{ eck_delivery_schedule } eck_delivery_schedule
LEFT JOIN { field_data_field_distribution_route_ref } field_data_field_distribution_route_ref ON eck_delivery_schedule.id = field_data_field_distribution_route_ref.entity_id
AND (
	field_data_field_distribution_route_ref.entity_type = 'delivery_schedule'
	AND field_data_field_distribution_route_ref.deleted = '0'
)
LEFT JOIN { eck_delivery_schedule } eck_delivery_schedule_field_data_field_distribution_route_ref ON field_data_field_distribution_route_ref.field_distribution_route_ref_target_id = eck_delivery_schedule_field_data_field_distribution_route_ref.id
LEFT JOIN { field_data_field_delivery_type } field_data_field_delivery_type ON eck_delivery_schedule.id = field_data_field_delivery_type.entity_id
AND (
	field_data_field_delivery_type.entity_type = 'delivery_schedule'
	AND field_data_field_delivery_type.deleted = '0'
)
LEFT JOIN { field_data_field_delivery_date } field_data_field_delivery_date ON eck_delivery_schedule.id = field_data_field_delivery_date.entity_id
AND (
	field_data_field_delivery_date.entity_type = 'delivery_schedule'
	AND field_data_field_delivery_date.deleted = '0'
)
LEFT JOIN { field_data_field_store_select } eck_delivery_schedule_field_data_field_distribution_route_ref__field_data_field_store_select ON eck_delivery_schedule_field_data_field_distribution_route_ref.id = eck_delivery_schedule_field_data_field_distribution_route_ref__field_data_field_store_select.entity_id
AND (
	eck_delivery_schedule_field_data_field_distribution_route_ref__field_data_field_store_select.entity_type = 'delivery_schedule'
	AND eck_delivery_schedule_field_data_field_distribution_route_ref__field_data_field_store_select.deleted = '0'
)
WHERE
	(
		(
			(
				DATE_FORMAT(
					STR_TO_DATE(
						field_data_field_delivery_date.field_delivery_date_value,
						'%Y-%m-%dT%T'
					),
					'%Y-%m'
				) >= '2017-07'
				AND DATE_FORMAT(
					STR_TO_DATE(
						field_data_field_delivery_date.field_delivery_date_value,
						'%Y-%m-%dT%T'
					),
					'%Y-%m'
				) <= '2017-07'
			)
		)
		AND (
			(
				eck_delivery_schedule_field_data_field_distribution_route_ref__field_data_field_store_select.field_store_select_value LIKE '%CN010001%' ESCAPE '\\'
			)
		)
		AND (
			(
				(
					field_data_field_delivery_type.field_delivery_type_target_id IS NOT NULL
				)
				AND (
					eck_delivery_schedule.erp_workflow_state IN ('published')
				)
			)
		)
	)
ORDER BY
	field_data_field_delivery_date_field_delivery_date_value ASC



	SELECT * FROM 
			   (SELECT SUM(kills) AS '沙僧' FROM user1 a JOIN user_kills b ON a.id=b.user_id AND a.user_name='沙僧') a
	CROSS JOIN (SELECT SUM(kills) as '猪八戒' FROM user1 a JOIN user_kills b ON a.id=b.user_id AND a.user_name='猪八戒') b
	CROSS JOIN (SELECT SUM(kills) as '送悟空' FROM user1 a JOIN user_kills b ON a.id=b.user_id AND a.user_name='送悟空') b

	
SELECT
	id AS id,
	subsidy_fine_date AS hr_subsidy_fine_subsidy_fine_date,
	subsidy_fine_type AS hr_subsidy_fine_subsidy_fine_type,
	employee_name AS hr_subsidy_fine_employee_name,
	employee_id AS hr_subsidy_fine_employee_id,
	making_date AS hr_subsidy_fine_making_date
FROM
	 hr_subsidy_fine
WHERE
	(
		(
			(
				institutions_id = 'CN010001'
			)
		)
		AND (
			(
				(
					subsidy_fine_date BETWEEN '1498838400'
					AND '1501516800'
				)
			)
		)
	)
ORDER BY
	hr_subsidy_fine_making_date DESC

	USE erp;

SELECT
	otherincomedate.bundle,
	#模块
	eck_cash.created,
	#创建日期
	eck_cash.store_id,
	#业务数据门店ID
	eck_cash.note,
	#备注
	otherincomeitem.field_otherincomeitem_tid AS otherincomeitem_tid,
	#其他业务收入项目ID
	otherincomemethod.field_otherincomemethod_tid AS paytype_tid,
	#收款方式ID
	otherincomedate.field_otherincomedate_value AS business_date,
	#业务日期
	eck_cash.amount,
	#金额
	otherincomequanlity.field_otherincomequanlity_value AS quanlity #数量
FROM
	field_data_field_otherincomedate AS otherincomedate
LEFT JOIN eck_cash_manage AS eck_cash ON otherincomedate.entity_id = eck_cash.id
LEFT JOIN field_data_field_otherincomemethod AS otherincomemethod ON otherincomedate.entity_id = otherincomemethod.entity_id
LEFT JOIN field_data_field_otherincomequanlity AS otherincomequanlity ON otherincomedate.entity_id = otherincomequanlity.entity_id
LEFT JOIN field_data_field_otherincomeitem AS otherincomeitem ON otherincomedate.entity_id = otherincomeitem.entity_id
WHERE
	eck_cash.store_id IN ('CN010003')
AND eck_cash.created = '2017-07-20'