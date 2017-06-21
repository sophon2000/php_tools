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

$cDevide  = array( 'coins','totalstock',
					'cost','exchange','recharge_money','money',
					'money',
				);
$cNoremal = array( 'expense_active','totalgift',);
var_dump(array_intersect(array(1,2), array(2)));
if(array_intersect(array(1,2), array(2)) === array(2)){
echo 'aaaaaaaa';
}
