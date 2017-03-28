<?php 

/**
 * 合并两个一维索引数组具有相同索引的进行相加first+second
 * @param  array  $first  [需要合并的数组]
 * @param  array  $second [需要合并的数组]
 * @param  array  $escape [不需要合并的字段]
 * @return [array]        [合并后的数组]
 */
function oneKeyMerge(array $first,array $second,$escape=array())
{
	// var_dump($first);var_dump($second);nbkjn
	if (!count($first) || !count($second)) {
		return(array) $first?$first:$second;
	}
	foreach($first as $k => $v)
		$first[$k] = intval($v);
	foreach($second as $k => $v)
		$second[$k] = intval($v);
	$one = array_diff_key($first,$second);
	$two = array_diff_key($second,$first);
	foreach ($first as $key => $value) {
		if (!in_array($key,$escape) && isset($second[$key])) {
			// 加操作
			$a = $value?$value:0;
			$b = $second[$key]?$second[$key]:0;
			$mid[$key] = floatval($value)+floatval($second[$key]);
		}
	}
	$new = array_merge($one,$two,$mid);
	return $new;
}


$first = array(
	 'coins' => 691,
	  'vip_id' => 4,
	  'num' => 275);
$second =array (
	  'coins' => 9,
	  'vip_id' => 6,
	  'num' => 5);

$merge = oneKeyMerge($first,$second);
var_dump($merge);