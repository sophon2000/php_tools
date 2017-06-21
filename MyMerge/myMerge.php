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
	function merge_time($arr1, $arr2,$condition = 'gt',$field = array('money'),$operation = '+')
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
		$small=$result1;
		$big=$result2;
		$middle = array();
		foreach ($result2 as $key => $value) {
			foreach ($result1 as $k => $v) {
				if ($value[$condition]==$v[$condition]) {
					// 合并
					$array1 = array_merge($value,$v);
					switch ($operation) {
						case '-':
							foreach ($field as $string) {
								$array1[$string]=strval(intval($value[$string])-intval($v[$string]));
							}
							break;			
						case '*':
							foreach ($field as $string) {
								$array1[$string]=strval(intval($value[$string])*intval($v[$string]));
							}
							break;
						case '':
							foreach ($field as $string) {
								$array1[$string]=$v[$string]?strval(intval($value[$string])/intval($v[$string])):false;
							}
							break;
						default:
							foreach ($field as $string) {
								$array1[$string]=strval(intval($value[$string])+intval($v[$string]));
							}
							break;
					}
					$middle[] = $array1;
					unset($big[$key]);
					unset($small[$k]);
				}
			}
		}
		$array = array();
		$array=array_merge($small,$middle,$big);
		return $array;
	}

$arr1= array (
	    array( 
	      'gt' =>  '201703281100',
	      'money' =>  '6.00'), 
	    array( 
	      'gt' =>  '201703281440',
	      'money' =>  '9.00')
	     ) ;
$arr2=array (
	    array( 
	      'gt' =>  '201703281100',
	      'money' =>  '44') 
	    ,array(
	      'gt' =>  '201703281240',
	      'money' =>  '20' )
	      );
// $arr1=array();
// $arr2=array();
var_dump(merge_time($arr1, $arr2,'gt',array('money'),'*'));