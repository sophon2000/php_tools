<?php 
/*
递归算法
 */

/**
 * 阶乘
 * @param  integer $param 被求阶乘的数
 * @return integer        阶乘后的值
 */
function demo($param)
{
	if ($param==1) {
		return 1;
	}
	return $param*demo($param-1);
}


/**
 * 进制转换
 * @param  integer $num       需要转换的十进制数
 * @param  integer $condition 转换为的进制
 * @param  array   $arr       站位
 * @return string             转换后的数
 */
function demo1($num,$condition,$arr=array())
{
	$num = intval($num);
	if ($num==0) {
		$newarr = array_reverse($arr);
		array_unshift($newarr,0);
		$str = implode('',$newarr);
		return $str;
	}
	$newnum = $num%$condition;
	$arr[] = $newnum;
	return demo1(floor($num/$condition),$condition,$arr);
}
echo $arr = demo1(321,10);
