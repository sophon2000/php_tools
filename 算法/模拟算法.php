<?php 

// echo rand()%6+1;


function demo($num)
{
	$m = 0;
	for ($i=1; $i <=$num ; $i++) { 
		$no = rand()%6+1;
		$m +=$no;
		echo '第'.$i.'粒: '.$no.'<br>';
	}
	echo '总点数: '.$m.'<hr>';

}

demo(5);	
demo(5);	
demo(5);	
demo(5);	

$n = 5;
$m = 4;

// echo $m .= $n;