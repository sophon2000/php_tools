<?php 
try {
	$connect = new PDO('mysql:host=127.0.0.1;dbname=sqltest','root','');
	$connect->query('set names utf8');
	$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	$connect->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
} catch (Exception $e) {
	echo $e->getMessage();
	exit;
}
try {
	$sql = 'select a.user_name,a.over,(select b.over from user2 b where b.user_name=a.user_name)as over2 from user1 a';
	$sql = 'select a.user_name,a.over,b.over as over2 from user1 a left join user2 b on a.user_name=b.user_name';
	$result = $connect->query($sql);
	$data = $result->fetchAll();
	echo '<table style="border:2px solid black">';
	echo '<tr><td style="border:1px solid black">user_name</td><td style="border:1px solid black">over</td><td style="border:1px solid black">over2</td></tr>';
	foreach ($data as $key => $value) {
			echo "<tr  >";
		foreach ($value as $k => $v) {
			
			echo '<td style="border:1px solid black">'.$v.'</td>';
		}
			echo "</tr>";
	}
	echo "</table>"	;
} catch (Exception $e) {
	echo $e->getMessage();
}