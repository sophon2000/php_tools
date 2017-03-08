<?php 
/*
贪婪算法(找零)
 */
// $parvalue = array( 10000,5000,1000,500,200,100,50,20,10 );
// $num = array(0,0,0,0,0,0,0,0,0);

function exchange($cash)
{
	global $parvalue,$num;
	$num = array(0,0,0,0,0,0,0,0,0);
	$parvalue = array( 10000,5000,1000,500,200,100,50,20,10 );

	for ($i=0; $i < 9; $i++) { 
		while ($cash>0 && $i<9) {
			if ($cash >= $parvalue[$i]){
				$cash = $cash - $parvalue[$i];
				$num[$i]++;
			} elseif ($cash < 10 && $cash>5){
				$num[9-1]++;
				break;
			} else {$i++;};
			
		}
	}
	return $num;
}

var_dump(exchange(18500)) ;
for ($i=0; $i < 9; $i++) { 
	echo $parvalue[$i]*$num[$i].'<br>';
}
