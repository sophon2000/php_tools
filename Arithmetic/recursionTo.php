<?php 
/*
递推算法(顺推)
  a b c d e
		X e
-----------
e e e e e e
 */

for ($a=1; $a < 10; $a++) { 
	for ($b=0; $b < 10; $b++) { 
		for ($c=0; $c < 10; $c++) { 
			for ($d=0; $d < 10; $d++) { 
				for ($e=1; $e < 10; $e++) { 
					$get = ($a*10000+$b*1000+$c*100+$d*10+$e);
					$check = $e*100000+$e*10000+$e*1000+$e*100+$e*10+$e;
					if ($get*$a == $check) {
							echo '<pre>';
							echo '     '.$a.$b.$c.$d.$e.'<br>';
							echo '        X'.$e.'<br>';
							echo '------------'.'<br>';
							echo '     '.$e.$e.$e.$e.$e.$e;
							echo '</pre>';
						}	
				}
			}
		}
	}
}