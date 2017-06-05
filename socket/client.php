<?php
error_reporting(E_ALL);
set_time_limit(0);
echo "<h2>TCP/IP Connection</h2>\n";
$port = 1935;
$ip = "127.0.0.1";
/*
 +-------------------------------
 *    @socket连接整个过程
 +-------------------------------
 *    @socket_create
 *    @socket_connect
 *    @socket_write
 *    @socket_read
 *    @socket_close
 +--------------------------------
*/
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
// 第一个参数”AF_INET”用来指定域名;
// 第二个参数”SOCK_STREM”告诉函数将创建一个什么类型的Socket(在这个例子中是TCP类型),UDP是SOCK_DGRAM

if ($socket < 0) {
    echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
} else {
    echo "OK.\n";
}
echo iconv('UTF-8', 'GB2312', "试图连接 '$ip' 端口 '$port'...\n");
$result = socket_connect($socket, $ip, $port);
if ($result < 0) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
} else {
    echo iconv('UTF-8', 'GB2312', "连接OK\n");
}
$in = "Ho\r\n";
$in.= "first blood\r\n";
$out = '';
if (!socket_write($socket, $in, strlen($in))) {
    echo iconv('UTF-8', 'GB2312', "socket_write() failed: reason: " . socket_strerror($socket) . "\n");
} else {
    echo iconv('UTF-8', 'GB2312', "发送到服务器信息成功！\n");
    echo iconv('UTF-8', 'GB2312',"发送的内容为:<font color='red'>$in</font> <br>" );
}
while ($out = socket_read($socket, 8192)) {
    echo iconv('UTF-8', 'GB2312', "接收服务器回传信息成功！\n");
    echo iconv('UTF-8', 'GB2312', "接受的内容为:"), $out;
}
echo iconv('UTF-8', 'GB2312',"关闭SOCKET...\n" );
socket_close($socket);
echo iconv('UTF-8', 'GB2312', "关闭OK\n");
?>