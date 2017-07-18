<?php 


/**
 * PHP计算两个时间段是否有交集（边界重叠不算）
 *
 * @param string $beginTime1 开始时间1
 * @param string $endTime1 结束时间1
 * @param string $beginTime2 开始时间2
 * @param string $endTime2 结束时间2
 * @return bool
 */
function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {
  $status = $beginTime2 - $beginTime1;
  if ($status > 0) {
    $status2 = $beginTime2 - $endTime1;
    if ($status2 > 0) {
      return false;
    } elseif ($status2 < 0) {
      return true;
    } else {
      return false;
    }
  } elseif($status < 0) {
    $status2 = $endTime2 - $beginTime1;
    if ($status2 > 0) {
      return true;
    } else if ($status2 < 0) {
      return false;
    } else {
      return false;
    }
  } else {
    $status2 = $endTime2 - $beginTime1;
    if ($status2 == 0) {
      return false;
    } else {
      return true;
    }
  }
}


/**
 * PHP计算两个时间段是否有交集（边界重叠不算）
 *
 * @param string $beginTime1 开始时间1
 * @param string $endTime1 结束时间1
 * @param string $beginTime2 开始时间2
 * @param string $endTime2 结束时间2
 * @return bool
 */
function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {
  $status = $beginTime2 - $beginTime1;
  if ($status > 0) {
    $status2 = $beginTime2 - $endTime1;
    if ($status2 >= 0) {
      return false;
    } else {
      return true;
    }
  } else {
    $status2 = $endTime2 - $beginTime1;
    if ($status2 > 0) {
      return true;
    } else {
      return false;
    }
  }

$beginTime1 = strtotime('2015-08-07 06:30');
$endTime1 = strtotime('2015-08-07 08:30');
$beginTime2 = strtotime('2015-08-07 05:30');
$endTime2 = strtotime('2015-08-07 06:31');
echo is_time_cross($beginTime1, $endTime1, $beginTime2, $endTime2);//输出1

