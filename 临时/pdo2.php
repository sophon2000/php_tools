<?php 
try {
	$connect = new PDO('mysql:host=127.0.0.1;dbname=sqltest','root','');
	$connect->query('set names utf8');
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$connect->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
	$connect->rollBack();
} catch (Exception $e) {
	echo $e->getMessage();
	exit;
}	
