<?php 
try {
	$connect = new PDO('mysql:host=127.0.0.1;dbname=sqltest','root','');
	$connect->query('set names utf8');
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$connect->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
	$connect->beginTransaction();
} catch (Exception $e) {
	echo $e->getMessage();
	exit;
}	
try {
	$sql = "UPDATE user2 set over = ? where user2.user_name in (select b.user_name from user1 a inner join user1 b on a.user_name = b.user_name)";
	$result = $connect->prepare($sql);
	$result->bindValue(1,'齐天大圣');
	$result->execute();
	$result->bindValue(2,'齐天大圣');
	$result->execute();
	echo $result->rowCount();
	$connect->commit();




} catch (Exception $e) {
	$connect->rollback();
	echo $e->getMessage();
	echo '<br>';
	echo $e->getLine();
}