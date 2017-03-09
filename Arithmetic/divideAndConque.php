<?php 
/*
分治算法
 */
$a = array();
/**
 * 参赛日程排列
 * @param  int $no    选手编号开始
 * @param  int $times 选手数
 * @return array        日期与选手数组
 */
function daily($no,$times)
{
	global $a;
	if ($times == 2) {
		$a[$no][1] = $no;
		$a[$no][2] = $no+1;
		$a[$no+1][1] = $no+1;
		$a[$no+1][2] = $no;
	}else{
		daily($no,$times/2);
		daily($no+$times/2,$times/2);
		for ($i=$no; $i < $no+$times/2; $i++) 
		{ 
			for ($j=$times/2+1; $j <= $times; $j++) 
			{ 
				$a[$i][$j] = $a[$i+$times/2][$j-$times/2];
			}
		}
		for ($i=$no+$times/2; $i < $no+$times; $i++) 
		{ 
			for ($j=$times/2+1; $j <= $times; $j++) { 
				$a[$i][$j] = $a[$i-$times/2][$j-$times/2];
			}
		}
	}
	return $a;
}
$time = 4;
$a = daily(1,$time);
var_dump($a);
for ($i=2; $i <= $time; $i++) {
	$day = $i-1; 
	echo '第'.$day.'天';
}
echo "<br>";
for ($i=1; $i <=$time; $i++) { 
	for ($j=1; $j <= $time; $j++) { 
		echo $a[$i][$j];
	}
	echo '<br>';
}
// print_r(daily(1,$time));