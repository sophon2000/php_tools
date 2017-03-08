<?php 
/*
递归算法
 */
function demo($param)
{
	if ($param==1) {
		return 1;
	}
	return $param*demo($param-1);
}
function demo1($num,$condition)
{
	$num = intval($num);
	if ($num==0) {
		return ;
	}
	$newnum = $num%$condition;
	global $arr;
	$arr[] = $newnum;
	return demo1(floor($num/$condition),$condition);
}
$arr = array();	
demo1(121,8);
$newarr = array_reverse($arr);
array_unshift($newarr,0);
$str = implode('',$newarr);
echo $str;