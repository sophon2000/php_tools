<?php 
$conn = fopen('http://tajs.qq.com/stats?sId=60411960', 'r');
echo $length = filesize('http://tajs.qq.com/stats?sId=60411960');
$str = fread($conn);
fclose($conn);
file_put_contents('./test1.js', $str);
echo 'ok';
