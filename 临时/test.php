<?php 
$cates = array();
$cates[]=array(1,0,'cate1');
$cates[]=array(2,0,'cate2');
$cates[]=array(3,2,'cate3');
$cates[]=array(4,2,'cate4');
$cates[]=array(5,3,'cate5');
$cates[]=array(6,3,'cate6');
$cates[]=array(7,0,'cate7');
// var_dump($cates);
function demo($parameter)
{
	foreach ($parameter as $key => $value) {
		if ($value[1]==0) {
			$a='&nbsp;';
		}else{
			$a='|';
		}
		for ($i=1; $i <= $value[1]; $i++) { 
			$a = $a.'---';
		}
		echo $a.$value[2].'<br>';
	}
}

demo($cates);
function demo1($parameter)
{
	static $a = 0;
	static $arr = '';
	// echo $a ;
	$result= $parameter;
	if ($a==0) {
		foreach ($parameter as $key => $value) {
			$arr[$value[0]]=$value[1];
		}
	}
	var_dump($arr);
	// echo $arr[3];
	for ($i=1; $i <= 7; $i++) { 
		if ($i==$result[$a][1]) {
			$tmp = $result[$i];
			$result[$i+1]= $result[$a];
			$result[$a]=$tmp;
		}
	}
	$a++;
	if ($a==7) {
		var_dump($result);
		exit;
	}
	demo1($result);
}
echo "<hr>";
demo1($cates);