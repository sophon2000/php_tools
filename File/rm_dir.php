<?php 

// echo $path        = __FILE__;
// echo $path     = dirname($path);
// echo $path     = basename($path);
// $dir = scandir($path);



/**
 * 递归删除目录及目录下的所有文件
 * @param  string $path 需要删除的目录
 * @return boolean   True为成功
 */
function my_rmdir($path)
{
	if (!file_exists($path)) {
		return false;
	}
	@$dh = opendir($path);
	while (!!$file = @readdir($dh)) {
		if ($file != '.'&& $file != '..') {
			if (!is_dir($file)) {
				unlink($file);	
			}else{
				my_rmdir($file);
			}
		}
	}
	@closedir($dh);
	if (@rmdir($path)) {
		return true;	
	}else{
		my_rmdir($path);
	}
}

/**
 * 递归删除目录及目录下的所有文件
 * @param  string $path 需要删除的目录
 * @return boolean   True为成功/False为失败
 */
function my_rmdir_two($path)
{	
	if (!file_exists($path)) {
		return false;
	}
	if (!!$list = @scandir($path)) {
		foreach ($list as $k => $v) {
			if ($v != '.' && $v != '..') {
				if (is_dir($path.'/'.$v)) {
					my_rmdir_two($path.'/'.$v);
				}else{
					unlink($path.'/'.$v);
				}
			}
		}
		if (@rmdir($path)) {
			return true;
		}else{
			my_rmdir_two($path);
		}
	}else{
		unlink($path);
	}
}

function deleteAll($path) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            deleteAll($op->path.'/'.$item);
            rmdir($op->path.'/'.$item);
        } else {
            unlink($op->path.'/'.$item);
        }
    
    }   
}

function renameAll($path,$dest) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            renameAll($op->path.'/'.$item,$dest);
            rename($op->path.'/'.$item);
        } else {
            rename($op->path.'/'.$item);
        }
    
    }   
}

$path = 'C:\wamp64\www\abcd\5';
$list = scandir($path);
foreach ($list as $key => $value) {
	if($value == '.' || $value == '..') {
            continue;
        }
	if(is_file($path.'\\'.$value)){
		$arr = explode('.', $value)[0];
		if(is_dir($path.'\\'.$arr.'.sdr')){
			rename($path.'\\'.$value, 'C:\wamp64\www\abcd\new\\'.$value);
			rename($path.'\\'.$arr.'.sdr', 'C:\wamp64\www\abcd\new\\'.$arr.'.sdr');
		}
	}
}
var_dump($list);
// exit;
// if (my_rmdir_two($path)) {
// 	echo 'SUCCESSFUL';
// }else{
// 	echo 'FAILED';
// }

$path = 'C:\wamp64\www\Develop\My\test';
exit;
if (my_rmdir_two($path)) {
	echo 'SUCCESSFUL';
}else{
	echo 'FAILED';
}


