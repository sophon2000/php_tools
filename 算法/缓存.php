<?php 

set_time_limit(0);
// 开启缓存
ob_start();
ob_clean();
$str = str_repeat('*', 2550);
ob_implicit_flush();
// echo $str;
// echo $str;
// // 立即传给浏览器
// ob_flush();
// flush(); 
// exit;
$i =0;
while (++$i) {
	echo $str.'<br>';
	echo $i.'<br>';
	// echo ob_get_contents();
	// echo ob_get_length();
	// var_dump(ob_get_status());
	echo "<hr>";
	// 立即传给浏览器
	ob_flush();
	// flush();
	sleep(2);
}