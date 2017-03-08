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
			var_dump($fullpath);
			if (!is_dir($fullpath)) {
				unlink($fullpath);	
			}else{
				my_rmdir($fullpath);
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

$path = 'C:\wamp64\www\Develop\My\test';
exit;
if (my_rmdir_two($path)) {
	echo 'SUCCESSFUL';
}else{
	echo 'FAILED';
}


