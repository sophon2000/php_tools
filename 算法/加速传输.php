<?php
// 二、 捕捉输出
// 以上的Example 4.是一种最简单的情况，你还可以在写入前对$content进行操作……
// 你可以设法捕捉一些关键字，然后去对它进行再处理，比如Example 3.所述的PHP语法高亮显示。个人认为，这个功能是此函数最大的精华所在，它可以解决各种各样的问题，但需要你有足够的想象力……
Function run_code($code) {
If($code) {
	ob_start();
	eval($code);
	$contents = ob_get_contents();
	ob_end_clean();
}else {
	echo "错误！没有输出";
	exit();
}
return $contents;
}
// 加快传输
// 以上这个例子的用途不是很大，不过很典型$code的本身就是一个含有变量的输出页面，而这个例子用eval把$code中的变量替换，然后对输出结果再进行输出捕捉，再一次的进行处理……

/*
** Title.........: PHP4 HTTP Compression Speeds up the Web
** Version.......: 1.20
** Author........: catoc <catoc@163.net>
** Filename......: gzdoc.php
** Last changed..: 18/10/2000
** Requirments...: PHP4 >= 4.0.1
** PHP was configured with --with-zlib[=DIR]
** Notes.........: Dynamic Content Acceleration compresses
** the data transmission data on the fly
** code by sun jin hu (catoc) <catoc@163.net>
** Most newer browsers since 1998/1999 have
** been equipped to support the HTTP 1.1
** standard known as \"content-encoding.\"
** Essentially the browser indicates to the
** server that it can accept \"content encoding\"
** and if the server is capable it will then
** compress the data and transmit it. The
** browser decompresses it and then renders
** the page.
**
** Modified by John Lim (jlim@natsoft.com.my)
** based on ideas by Sandy McArthur, Jr
** Usage........:
** No space before the beginning of the first \'<?\' tag.
** ------------Start of file----------
** |<?
** | include(\'gzdoc.php\');
** |? >
** |<HTML>
** |... the page ...
** |</HTML>
** |<?
** | gzdocout();
** |? >
** -------------End of file-----------
*/
ob_start();
ob_implicit_flush(0);
function CheckCanGzip(){
	global $HTTP_ACCEPT_ENCODING;
	if (headers_sent() || connection_timeout() || connection_aborted()){
		return 0;
	}
	if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) return "x-gzip";
	if (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) return "gzip";
	return 0;
}
/* $level = compression level 0-9, 0=none, 9=max */
function GzDocOut($level=1,$debug=0){
	$ENCODING = CheckCanGzip();
	if ($ENCODING){
		print "n<!-- Use compress $ENCODING -->n";
		$Contents = ob_get_contents();
		ob_end_clean();
		if ($debug){
			$s = "<p>Not compress length: ".strlen($Contents);
			$s .= "
			Compressed length: ".strlen(gzcompress($Contents,$level));
			$Contents .= $s;
		}
		header("Content-Encoding: $ENCODING");
		print "x1fx8bx08x00x00x00x00x00";
		$Size = strlen($Contents);
		$Crc = crc32($Contents);
		$Contents = gzcompress($Contents,$level);
		$Contents = substr($Contents, 0, strlen($Contents) - 4);
		print $Contents;
		print pack('V',$Crc);
		print pack('V',$Size);
		exit;
	}else{
		ob_end_flush();
		exit;
	}
}
// CheckCanGzip();
// var_dump($HTTP_ACCEPT_ENCODING);
GzDocOut();
?>