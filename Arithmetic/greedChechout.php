<?php 
/*
贪婪算法(找零)
 */

/**
 * 找零函数
 * @param  integer $cash     需要找零的钱(元)*100
 * @param  array  $parvalue  金币面值(元)*100
 * @return [array]           包含找零钱数的数组
 */
function exchange($cash,$parvalue=array( 10000,5000,1000,500,200,100,50,20,10 ))
{
	$i = 0;
	$times = count($parvalue);
	foreach ($parvalue as $k => $v) {
		$num[] = 0;
	}
		
	while ($cash>0 && $i<$times) {
		if ($cash >= $parvalue[$i]){
			$cash = $cash - $parvalue[$i];
			$num[$i]++;
		} elseif ($cash<$parvalue[$times-1] && $cash>$parvalue[$times-1]/2){
			$num[$times-1]++;
			break;
		} else {$i++;};
		
	}
	foreach ($num as $k => $v) {
		$newNum[$parvalue[$k]] = $v;
	}
	return $newNum;
}

var_dump(exchange(18506)) ;exit;
