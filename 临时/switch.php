<?php 
$str = true;
$str = 3;
switch ($str) {
	case 1:
		echo 1;
		break;
	case 2:
		echo 2;
		break;
	case true:
		if ($str===4) {
			echo 3;
		}else{
			echo 'true';
			
		}
		break;
	default:
		echo 'else';
		break;
}