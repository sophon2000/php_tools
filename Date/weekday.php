<?php 
/**
 * [get_weekend_days 获得工作日或周末天数]
 * @param  [type]  $start_date [开始时间]
 * @param  [type]  $end_date   [结束时间]
 * @param  boolean $is_workday [是否为工作日]
 * @return [type]              [天数]
 */
function get_weekend_days($start_date,$end_date,$is_workday = false)
{ 
	if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date); 
	$start_reduce = $end_add = 0; 
	$start_N = date('N',strtotime($start_date)); 
	$start_reduce = ($start_N == 7) ? 1 : 0; 
	$end_N = date('N',strtotime($end_date)); 
	in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1; 
	$alldays = abs(strtotime($end_date) - strtotime($start_date))/86400 + 1; 
	$weekend_days = floor(($alldays + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add; 
	if ($is_workday){ 
		$workday_days = $alldays - $weekend_days; 
		return $workday_days; 
	} 
	return $weekend_days; 
} 
