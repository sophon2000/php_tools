<?php 
define('NO', 10);
echo NO;
// exit;
for ($i=1; $i <= NO ; $i++) { 
		$num[] = $i;
	}
// shuffle($num);
function caipiao($n,$m)
{
	global $lottery,$arr,$num;
	for ($i=$n; $i >= $m; $i--) { 
		$lottery[$m-1] = $num[$i-1];
		if ($m>1) {
			caipiao($i-1,$m-1);
			// var_dump($arr);
		}else{
			if (count($arr) == 50) {
				$arr = get_sort($arr);
				var_dump($arr);
				exit;
			}
			// shuffle($lottery);
			$arr[] = implode(' ',$lottery);
			// shuffle($num);
		}
	}
}
caipiao(NO,5);

function get_sort($arr)

{
	for ($i=0; $i < count($arr); $i++) { 
		$arr[$i] = explode(' ', $arr[$i]);
		sort($arr[$i]);
		$arr[$i] = array_reverse($arr[$i]);
		$arr[$i] = implode(' ', $arr[$i]);

	}
	return $arr;
}


