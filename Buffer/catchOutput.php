 <?php
/**
 * 静态模版技术
 * 我所知道的实现静态输出的有两种办法：
 * <1>.通过y10k修改的phplib的一个叫template.inc.php类实现。
 * <2>.使用ob系列函数实现。
 */

ob_start();                                 //打开缓冲区
// 页面的全部输出
$content = ob_get_contents();               //取得php页面输出的全部内容
// 处理内容
$content = str_replace('{', '<?php' , $content);
$content = str_replace('}', '?>' , $content);
$content = run_code($content);

$fp      = fopen("output00001.html", "w");  //创建一个文件，并打开，准备写入
fwrite($fp, $content);                      //把php页面的内容全部写入output00001.html，然后……
fclose($fp);

/**
 * 捕捉变量运行后的内容		
 * @param  [string] $code [需要处理的内容]
 * @return [string]       [输出的内容]
 */
function run_code($code) 
{
	if($code) {
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
 