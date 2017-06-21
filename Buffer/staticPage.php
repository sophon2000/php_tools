<?php
/**
 * 加快传输
 */

ob_start();
ob_implicit_flush(0);
function CheckCanGzip()
{
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
		$Size     = strlen($Contents);
		$Crc      = crc32($Contents);
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