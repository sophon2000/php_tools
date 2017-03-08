<?php 
/*
一群猴子排成一圈，按1，2，…，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，
从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下
一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
 */


function monkeyRound($n = 50,$m = 7)
{
	static $i = 0;
	static $a = 0;
	global $monkey;
	if ($i) {
		$i = 1;
		foreach ($monkey as $k => $v) {
			$newmonkey[$i] = $v;
			$i++;
		}
		$monkey = $newmonkey;
	}else{
		for ($i=1; $i <= $n; $i++) { 
			 $monkey[$i] = $i;
		}
	}
	if (count($monkey)<=7) {
			$i = 8;
			$a = 1;
		foreach ($monkey as $k => $v) {
			$newmonkey[$k] = $v;
			$newmonkey[$i] = $v;
			$i++;
		}
		$monkey = $newmonkey;
	}
	if ($a) {
		foreach ($monkey as $k => $v) {
			if ($k%$m ==0) {
				$x = $v;
			}
		}
		foreach ($monkey as $k => $v) {
			if ($v == $x) {
				unset($monkey[$k]);
			}
		}
		$i = 1;
		foreach ($monkey as $k => $v) {
			$newmonkey[$i] = $v;
			$i++;
		}
		$monkey = $newmonkey;
	}else{
		foreach ($monkey as $k => $v) {
			if ($k%$m ==0) {
				unset($monkey[$k]);
			}
		}
	}
	
	var_dump($monkey);
	sleep(1);
	if ($n =count($monkey)>1) {
		$i++;
		monkeyRound($n,$m);
	}else{
		return $monkey;
	}
}

var_dump(monkeyRound());