<?php 

function download($file_name)
{
	$file_name = iconv('UTF-8', 'GBK2312', $file_name);
	$file_path = $_SERVER['DOCUMENT_ROOT'].'/demo/oppject/'.$file_name;
	if (!file_exists($file_path)) {
		return 'no file!';
	}
	$fp = fopen($file_path, 'r');
	$file_size = filesize($file_path);
	if ($file_size>1) {
		
		return '文件过大,没权限下载';
	}
	header("Content-type: application/octet-stream");
	header("Accept-Ranges: bytes");
	header("Accept-Length: ".$file_size);
	header("Content-Disposition: attachement;filename=".$file_name);

	$buffer = 1024;
	while (!feof($fp) && ($filesize-$file_count>0)) {
		$file_data = fread($fp, $buffer);
		$file_count +=$buffer;
		echo "$file_data";
	}
	fclose($fp);
}