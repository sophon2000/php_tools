<?php 


// 发现问题
$a =   9.7*100;
// $a =  ( string ) $a;
echo floor($a) / 100;  // return 9.69
echo '<hr>';

// 临时解决问题 
$a =   9.7*100;
$a =  ( string ) $a;
echo floor($a) / 100;  // return 9.7
echo '<hr>';

// 分析问题
for ($i=0; $i <= 9; $i++) { 
	$a = "9".".$i";
	$a = $a*100;
	$b = floor($a) / 100;
	echo "</br>$b";

}
echo '<hr>';

// 发现bc系列函数  bcmul bcsqrt bcdiv
// 发现函数  deg2rad pi


// 官方手册发现类似issue

$int = '0.9999999999999999'; 
var_dump(strlen($int));
echo floor($int); // returns 0 

echo '</br>';

$int = '0.99999999999999999'; 
var_dump(strlen($int));
echo floor($int); // returns 1 
echo '<hr>';

// 最终解决方案
$length = 9.7;
$length = floor(($length) * 100 + .5) * .01;
print "$length";


