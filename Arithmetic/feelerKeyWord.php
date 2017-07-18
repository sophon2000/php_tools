<?php 
$a = ['A','B','C'];
for ($i=0; $i < 3; $i++) { 
	for ($j=$i+1; $j < 3; $j++) { 
		$_a[] = $a[$i].$a[$j];
		$_a[] = $a[$j].$a[$i];
	}
}
// print_r($_a);

// key word 
$key = 'I am a geeker!';

$key = explode(' ', $key);
$key = array_reverse($key);

/**
 * 关键字组合（试探算法）
 * $n 元素总数字，$m取几个
 * global $arr 结果数组 $key 参数数组 $sentence 中间数组 
 */
function key_word($n,$m)
{
	global $sentence,$arr,$key;
	for ($i=$n; $i >= $m; $i--) { 
		$sentence[$m-1] = $key[$i-1];
		// print_r($sentence);
		// ob_flush();	
		// sleep(1);
		if ($m>1) {
			key_word($i-1,$m-1);
		}else{
			//防止数据过多
			if (count($arr) == 50) exit;
			$arr[] = implode(' ',$sentence);
		}
	}
}

// function get_sort(&$arr)

// {
// 	for ($i=0; $i < count($arr); $i++) { 
// 		$arr[$i] = explode(' ', $arr[$i]);
// 		sort($arr[$i]);
// 		$arr[$i] = array_reverse($arr[$i]);
// 		$arr[$i] = implode(' ', $arr[$i]);

// 	}
// }
// ob_start();
// ob_clean();
// ob_implicit_flush();

$total = count($key);
for ($K=$total; $K >0; $K--) {
	unset($sentence); 
	key_word($total,$K);
}

var_dump($arr);

