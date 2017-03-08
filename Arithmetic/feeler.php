<?php 
/*
试探算法
 */
// for ($i[0]=1; $i[0] < 10; $i[0]++) { 
// 	for ($i[1]=1; $i[1] < 10; $i[1]++) { 
// 		if ($i[0]==$i[1]) continue;
// 		for ($i[2]=1; $i[2] < 10; $i[2]++) { 
// 			if($i[0]==$i[2] || $i[1]==$i[2]) continue;
// 			for ($i[3]=1; $i[3] < 10; $i[3]++) { 
// 				if($i[0]==$i[3] || $i[1]==$i[3] || $i[2]==$i[3]) continue;
// 				for ($i[4]=1; $i[4] < 10; $i[4]++) { 
// 					if($i[0]==$i[4] || $i[1]==$i[4] || $i[2]==$i[4] || $i[3]==$i[4]) continue;
// 					for ($i[5]=1; $i[5] < 10; $i[5]++) { 
// 						if($i[0]==$i[5] || $i[1]==$i[5] || $i[2]==$i[5] || $i[3]==$i[5]|| $i[4]==$i[5]) continue;
// 						for ($i[6]=1; $i[6] < 10; $i[6]++) { 
// 							if($i[0]==$i[6] || $i[1]==$i[6] || $i[2]==$i[6] || $i[3]==$i[6]|| $i[4]==$i[6] || $i[5]==$i[6]) continue;
// 							$newarr[] = implode(' ', $i);
// 							if (count($newarr)==50) {
// 								// var_dump($newarr);
// 								break 7;
// 							}
// 						}
// 					}
// 				}
// 			}
// 		}
// 	}
// }
echo "string";
function caipiao($n,$m,$no=30)
{
	for ($i=1; $i <= $no ; $i++) { 
		$num[] = $i;
	}
	global $lottery;
	for ($i=$n; $i >= $m; $i--) { 
		$lottery[$m-1] = $num[$i-1];
		if ($m>1) {
			caipiao($i-1,$m-1);
		}else{
			return $lottery;
		}
	}

}

var_dump(caipiao(29,9));
var_dump($lottery);
