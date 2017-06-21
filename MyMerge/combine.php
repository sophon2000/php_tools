<?php 
/**
 * 以一个关键字段合并两个二维数组
 * @param  [array] $arr1      [合并的第一个数组]
 * @param  [array] $arr2      [合并的第二个数组]
 * @param  string $condition  [关键字段]
 * @param  array  $field      [需要运算的字段]
 * @param  string $operation  [运算方式/被除数为0的话返回false]
 * @return [array]            [合并后的数组]
 */
function my_merge($arr1, $arr2,$condition = 'gt',$field = array('money'),$operation = '+')
{
	$length1=count($arr1);
	$length2=count($arr2);
	// 如果有空的
	if (!$length2 || !$length1) {
		return $arr = $arr1?$arr1:$arr2;
	}
	// 比较大小
	if ($length1>$length2) {
		$result1=$arr1;
		$result2=$arr2;
	}else{
		$result1=$arr2;
		$result2=$arr1;
	}

	// 开始合并
	$array1=array();
	$middle = array();
	$big = array();
	$small = array();
	foreach ($result2 as $key => $value) {
		foreach ($result1 as $k => $v) {
			if ($value[$condition]==$v[$condition]) {
				// 合并
				$total = array_merge($value,$v);
				foreach($total as $_key =>$_value){
					$newtotal[]=$_key;
				}
//					var_dump($value);var_dump($v);var_dump($field);
				$escape = array_diff($newtotal,$field);
				$array1 = oneKeyMerge($value,$v,$escape,$operation,$condition);
				$middle[] = $array1;
				unset($result2[$key]);
				unset($result1[$k]);
			}
		}
	}
	$small=$result1;
	$big=$result2;
	$array = array();
	$array=array_merge($small,$middle,$big);
	return $array;
}

/**
 * 合并两个一维索引数组具有相同索引的进行相加first+second
 * @param  array  $first  [需要合并的数组]
 * @param  array  $second [需要合并的数组]
 * @param  array  $escape [不需要合并的字段]
 * @param  array  $condition [共有不需要合并的字段]
 * @return [array]        [合并后的数组]
 */
function oneKeyMerge(array $first,array $second,$escape=array(),$operation='+',$condition=false)
{
	if (!count($first) || !count($second)) {
		return(array) $first?$first:$second;
	}

	$one = array_diff_key($first,$second);
	$two = array_diff_key($second,$first);
	$mid = array();
	foreach ($first as $key => $value) {
		echo $key.'<br>';
		if (!in_array($key,$escape) && isset($second[$key])) {
			echo 'b '.$key.' b<br>';
			$first[$key] = floatval($value);
			$second[$key] = floatval($second[$key]);
			switch ($operation) {
				case '-':
					$mid[$key] = $value-$second[$key];
					break;
				case '*':
					$mid[$key] = $value*$second[$key];
					break;
				case '/':
					$mid[$key] = $second[$key]?$value/$second[$key]:false;
					break;
				default:
					$mid[$key] = $value+$second[$key];
					break;
			}
		}
	}
	$condition?$mid2[$condition] = $first[$condition]:$mid2 = array();
	var_dump($mid);
	$new = array_merge($one,$two,$mid,$mid2);
echo 'aaaaaaaaaaaaaaaaaaaa';

	return $new;
}
$one=array (
  'num_new' => null,
  'money' =>  0,
  'vip_id' =>  0);
$two=array (
  'money' => null,
  'vip_id' =>  '0',
  'num' =>  '0');
var_dump(oneKeyMerge($one,$two));

var_dump(isset($two['money']));