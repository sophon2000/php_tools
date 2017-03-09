<?php 
/*
获取phpinfo
 */
ob_start();
phpinfo();
$info = ob_get_contents();
$file = fopen('./info.txt', 'w');
fwrite($file, $info);
fclose($file);
