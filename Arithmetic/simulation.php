<?php 
/*
模拟算法
掷骰子
 */

function demo($num)
{
	$m = 0;
	for ($i=1; $i <=$num ; $i++) { 
		$no = rand()%6+1;
		$m +=$no;
		$result['list'][$i]=$no;
	}
	$result['total']=$m;
	return $result;
}

var_dump(demo(5));	

