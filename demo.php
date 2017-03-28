<?php 
function demo($condition = 'email',$match,$min=6,$max=20)
{
	switch ($condition) {
		case 'phone':
			// 验证手机的操作
			break;
		case 'email':
			// 验证email的操作
			break;
		case 'user':
			// 验证用户的操作
			break;
		default:
			# code...1
			break;
	}
}


	