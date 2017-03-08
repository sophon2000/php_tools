<?php 
/*
递推算法(逆推)
现在存多少钱后边48个月每个月可以取1000块
年利率0.0171
 */


/**
 * 逆退计算整存零取
 * @param  [type] $money [description]
 * @param  [type] $times [description]
 * @return [type]        [description]
 */
function get_total($money,$times)
{
	$a[$times] = $money;
	for ($i=$times-1; $i >0; $i--) { 
		$a[$i] = $a[$i+1]+$money/(1+0.0171/12);
	}
	return $a;
}
print_r(get_total(1000,48));