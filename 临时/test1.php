<?php

/*

已知分类数据，含义为：第一列为 id, 第二列为 parentid, 第三列为分类名
设计两个函数，一个以递归的方式输出以下结构的字符串，另外一个以循环的方式。

cate 1
cate 2
|----cate 3
|--------cate 5
|--------cate 6
|----cate 4
cate 7

*/

$cates = array();
$cates[0] = array(1, 0, 'cate 1');
$cates[1] = array(2, 0, 'cate 2');
$cates[2] = array(3, 2, 'cate 3');
$cates[3] = array(4, 2, 'cate 4');
$cates[4] = array(5, 3, 'cate 5');
$cates[5] = array(6, 3, 'cate 6');
$cates[6] = array(7, 0, 'cate 7');
$cates[7] = array(8, 4, 'cate 8');
$cates[8] = array(9, 4, 'cate 9');

function gen_cate_by_recursive() {

}
$arr1=array();
$arr2=array();
function gen_cate_by_loop($cates=array()) {
	foreach ($cates as $v) {
		$arr1[]=$v[0];	
		$arr2[]=$v[1];
	}
	$_SESSION=array();
	foreach ($cates as $v) {
		$nbsp='';
		if ($v[1]>1) {
			$num=$v[1]-1;
			$nbsp = str_repeat('----', $num);
		}
		if (in_array($v[1],$arr1)) {
			if (in_array($v[1],$_SESSION)) {
				continue;
			}
			echo '|'.$nbsp.$v[2].'<br>';
			if (in_array($v[0],$arr2)) {
				$_SESSION[]=$v[0];
				foreach ($cates as $val) {
					if ($v[0]==$val[1]) {
						echo '|----'.$nbsp.$val[2].'<br>';
					}
				}
			}
		}else{
			echo $v[2].'<br>';
		}
	}
}
gen_cate_by_loop($cates);
?>