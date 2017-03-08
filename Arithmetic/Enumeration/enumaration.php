<?php 
/*
枚举算法
 */
if (isset($_POST['input1'])&&isset($_POST['input2'])&&
	isset($_POST['input3'])&&isset($_POST['input4'])&&
	isset($_POST['input5'])&&isset($_POST['input6'])) {
	$num = array( '',$_POST['input1'],$_POST['input2'],$_POST['input3'],
					$_POST['input4'],$_POST['input5'] );
	$result = $_POST['input6'];
}else{
	$num = array( '',5,5,5,5,5 );
	$result = 5;
}
$opera = array('','+','-','*','/');
$count = 0;
for ($i[1]=1; $i[1] <= 4; $i[1]++) { 
	if ($i[1]<4 || ($num[2]!=0)) {
		for ($i[2]=1; $i[2] <=4; $i[2]++) { 
			if ($i[2]<4 || ($num[3]!=0)) {
				for ($i[3]=1; $i[3] <=4; $i[3]++) { 
					if ($i[3]<4 || ($num[4]!=0)) {
						for ($i[4]=1; $i[4] <=4; $i[4]++) { 
							if ($i[4]<4 || ($num[5]!=0)) {
								$left = 0;
								$right = $num[1];
								$sign = 1;
								for ($j=1; $j <= 4; $j++) { 
									switch ($opera[$i[$j]]) {
										case '+':
											$left = $left+$sign*$right;
											$sign = 1;
											$right = $num[$j+1];
											break;
										case '-':
											$left = $left+$sign*$right;
											$sign = -1;
											$right = $num[$j+1];
											break;
										case '*':
											$right = $right*$num[$j+1];
											break;
										case '/':
											$right = $right/$num[$j+1];
											break;
										default:
											# code...
											break;
									}
								}
								if ($left+$sign*$right==$result) {
									$count++;
									echo '<hr>';
									for ($j=1; $j <= 4; $j++) { 
										echo $num[$j].$opera[$i[$j]];
									}
									echo $num[5].'='.$result.'<br>';
								}
							}
						}
					}
				}
			}
		}
	}
}
echo '次数:'.$count;