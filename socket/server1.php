<?php  
/** 
 * SocketServer Class 
 * By James.Huang <shagoo#gmail.com> 
**/  
set_time_limit(0);  
class SocketServer   
{  
    private static $socket;  
    function SocketServer($port)   
    {  
        global $errno, $errstr;  
        if ($port < 1024) {  
            die("Port must be a number which bigger than 1024/n");  
        }  
          
        $socket = stream_socket_server("tcp://127.0.0.1:{$port}", $errno, $errstr);  
        if (!$socket) die("$errstr ($errno)");  
          
//      stream_set_timeout($socket, -1); // 保证服务端 socket 不会超时，似乎没用：）  
          
        while ($conn = stream_socket_accept($socket, -1)) { // 这样设置不超时才有用  
            static $id = 0;  
            static $ct = 0;  
            $ct_last = $ct;  
            $ct_data = '';  
            $buffer = '';  
            $id++; // increase on each accept  
            echo "Client $id come./n";  
            while (!preg_match("/\/r?\/n/", $buffer)) { // 没有读到结束符，继续读  
//              if (feof($conn)) break; // 防止 popen 和 fread 的 bug 导致的死循环  
                $buffer = fread($conn, 1024);  
                echo 'R'; // 打印读的次数  
                $ct += strlen($buffer);  
                $ct_data .= preg_replace('/\/r?\/n/', '', $buffer);  
            }  
            $ct_size = ($ct - $ct_last) * 8;  
            echo "[$id] " . __METHOD__ . " > " . $ct_data . "/n";  
            fwrite($conn, "Received $ct_size byte data./r/n");  
            fclose($conn);  
        }  
          
        fclose($socket);  
    }  
}  
new SocketServer(2000); 