<?php  
/** 
 * Socket Test Client 
 * By James.Huang <shagoo#gmail.com> 
**/  
function debug ($msg)  
{  
//  echo $msg;  
    error_log($msg, 3, '/tmp/socket.log');  
}  
if (isset($argv[1]) && $argv[1]) {  
      
    $socket_client = stream_socket_client('tcp://127.0.0.1:2000', $errno, $errstr, 30);  
      
//  stream_set_blocking($socket_client, 0);  
 stream_set_timeout($socket_client, 0, 100000);  
      
    if (!$socket_client) {  
        die("$errstr ($errno)");  
    } else {  
        $msg = trim($argv[1]);  
        for ($i = 0; $i < 10; $i++) {  
            $res = fwrite($socket_client, "$msg($i)");  
            usleep(100000);  
            echo 'W'; // 打印写的次数  
         debug(fread($socket_client, 1024)); // 不打开16行时候将产生死锁，因为 fread 在阻塞模式下未读到数据时将等待  
        }  
        fwrite($socket_client, "/r/n"); // 传输结束符  
        debug(fread($socket_client, 1024));  
        fclose($socket_client);  
    }  
}  
else {  
      
//  $phArr = array();  
//  for ($i = 0; $i < 10; $i++) {  
//      $phArr[$i] = popen("php ".__FILE__." '{$i}:test'", 'r');  
//  }  
//  foreach ($phArr as $ph) {  
//      pclose($ph);  
//  }  
      
    for ($i = 0; $i < 10; $i++) {  
        system("php ".__FILE__." '{$i}:test'");  
    }  
}  