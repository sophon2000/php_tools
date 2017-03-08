<?php 
/*
试探算法
 */
/**
 * 随机生成不重复的七位数
 * @param  integer $start 随机数的最小值
 * @param  integer $end   随机数的最大值
 * @param  integer $times 获得多少个随机数
 * @return array         包含随机数的数组
 */
function get_random($start=1,$end=10,$times=50)
{
	$end = $end+1;
	for ($i[0]=$start; $i[0] < $end; $i[0]++) { 
		for ($i[1]=$start; $i[1] < $end; $i[1]++) { 
			if ($i[0]==$i[1]) continue;
			for ($i[2]=$start; $i[2] < $end; $i[2]++) { 
				if($i[0]==$i[2] || $i[1]==$i[2]) continue;
				for ($i[3]=$start; $i[3] < $end; $i[3]++) { 
					if($i[0]==$i[3] || $i[1]==$i[3] || $i[2]==$i[3]) continue;
					for ($i[4]=$start; $i[4] < $end; $i[4]++) { 
						if($i[0]==$i[4] || $i[1]==$i[4] || $i[2]==$i[4] || $i[3]==$i[4]) continue;
						for ($i[5]=$start; $i[5] < $end; $i[5]++) { 
							if($i[0]==$i[5] || $i[1]==$i[5] || $i[2]==$i[5] || $i[3]==$i[5]|| $i[4]==$i[5]) continue;
							for ($i[6]=$start; $i[6] < $end; $i[6]++) { 
								if($i[0]==$i[6] || $i[1]==$i[6] || $i[2]==$i[6] || $i[3]==$i[6]|| $i[4]==$i[6] || $i[5]==$i[6]) continue;
								$newarr[] = implode(' ', $i);
								if (count($newarr)==$times) {
									break 7;
								}
							}
						}
					}
				}
			}
		}
	}
	return $newarr;
}

/**
 * [产生不重复的随机数]
 * @param  [integer]  $no  [最大数]
 * @param  [integer]  $m  [多少位]
 * @param  integer $no [随机数字范围1-$no]
 * @return [type]      [数]
 */
function caipiao($no = 30,$m)
{
	for ($i=1; $i <= $no ; $i++) { 
		$num[] = $i;
	}
	global $lottery;
	for ($i=$no; $i >= $m; $i--) { 
		$lottery[$m-1] = $num[$i-1];
		if ($m>1) {
			caipiao($i-1,$m-1);
		}else{
			return $lottery;
		}
	}
	return $lottery;

}

// var_dump(caipiao(9,9));
for($i=0;$i<=3;$i++){   
	echo str_repeat(" ",3-$i);   
	echo str_repeat("*",$i*2+1);   
	echo '<br/>'; 
}
