<?php  
/** 
 * SelectSocketServer Class 
 * By James.Huang <shagoo#gmail.com> 
**/  
set_time_limit(0);  
class SelectSocketServer   
{  
    private static $socket;  
    private static $timeout = 60;  
    private static $maxconns = 1024;  
    private static $connections = array();  
    function SelectSocketServer($port)   
    {  
        global $errno, $errstr;  
        if ($port < 1024) {  
            die("Port must be a number which bigger than 1024/n");  
        }  
          
        $socket = socket_create_listen($port);  
        if (!$socket) die("Listen $port failed");  
          
        socket_set_nonblock($socket); // 非阻塞  
          
        while (true)   
        {  
            $readfds = array_merge(self::$connections, array($socket));  
            $writefds = array();  
            // 选择一个连接，获取读、写连接通道  
            $e = null;
            if (socket_select($readfds, $writefds, $e, $t = self::$timeout))   
            {  
                // 如果是当前服务端的监听连接  
                if (in_array($socket, $readfds)) {  
                    // 接受客户端连接  
                    $newconn = socket_accept($socket);  
                    $i = (int) $newconn;  
                    $reject = '';  
                    if (count(self::$connections) >= self::$maxconns) {  
                        $reject = "Server full, Try again later./n";  
                    }  
                    // 将当前客户端连接放入 socket_select 选择  
                    self::$connections[$i] = $newconn;  
                    // 输入的连接资源缓存容器  
                    $writefds[$i] = $newconn;  
                    // 连接不正常  
                    if ($reject) {  
                        socket_write($writefds[$i], $reject);  
                        unset($writefds[$i]);  
                        self::close($i);  
                    } else {  
                        echo "Client $i come./n";  
                    }  
                    // remove the listening socket from the clients-with-data array  
                    $key = array_search($socket, $readfds);  
                    unset($readfds[$key]);  
                }  
                  
                // 轮循读通道  
                foreach ($readfds as $rfd) {  
                    // 客户端连接  
                    $i = (int) $rfd;  
                    // 从通道读取  
                    $line = @socket_read($rfd, 2048, PHP_NORMAL_READ);  
                    if ($line === false) {  
                        // 读取不到内容，结束连接            
                        echo "Connection closed on socket $i./n";  
                        self::close($i);  
                        continue;  
                    }  
                    $tmp = substr($line, -1);  
                    if ($tmp != "/r" && $tmp != "/n") {  
                        // 等待更多数据  
                        continue;  
                    }  
                    // 处理逻辑  
                    $line = trim($line);  
                    if ($line == "quit") {  
                        echo "Client $i quit./n";  
                        self::close($i);  
                        break;  
                    }  
                    if ($line) {  
                        echo "Client $i >>" . $line . "/n";  
                    }  
                }  
                  
                // 轮循写通道  
                foreach ($writefds as $wfd) {  
                    $i = (int) $wfd;  
                    $w = socket_write($wfd, "Welcome Client $i!/n");  
                }  
            }  
        }  
    }  
      
    function close ($i)   
    {  
        socket_shutdown(self::$connections[$i]);  
        socket_close(self::$connections[$i]);  
        unset(self::$connections[$i]);  
    }  
}  
new SelectSocketServer(2000);  