<?php 
$url = new Http('http://localhost/sms/index.php/login');
echo $url->get(array('name'=>'zsy','password'=>'1234'));
echo 'ok';