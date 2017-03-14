<?php
/**
 * 自定义模板引擎
 */
 
 /**
  * [template description]
  * @param  [string] $filename [文件名]
  * @param  [type]   $flag     [TEMPLATE_DISPLAY默认输出/TEMPLATE_FETCH获得页面内容
  *                            /TEMPLATE_INCLUDEPATH获得引入文件地址]
  * @param  [array]  $GLOBALS  [数据]
  * @return [type]           [description]
  */
function template($filename,$flag = TEMPLATE_DISPLAY $GLOBALS = array()) {
	// html原文件
	$source = "./view/{$filename}.html";
	// 解析生成的php文件
	$compile = "./run/{$filename}.tpl.php";
	// 不存在往下级地址找文件
	if(!is_file($source)) {
		$source =   "./common/{$filename}.html";
		$compile =   "./common/{$filename}.tpl.php";
	}
	// 确实不存在
	if(!is_file($source)) {
		exit("Error: template source '{$filename}' is not exist!");
	}
	// 判断是否解析html模板
	if( !is_file($compile) || filemtime($source) > filemtime($compile) ) {
		// 解析模板
		template_compile($source, $compile);
	}
	switch ($flag) {
		case TEMPLATE_DISPLAY:
		default:
			extract($GLOBALS, EXTR_SKIP);
			include $compile;
			break;
		case TEMPLATE_FETCH:
			extract($GLOBALS, EXTR_SKIP);
			ob_flush();
			ob_clean();
			ob_start();
			include $compile;
			$contents = ob_get_contents();
			ob_clean();
			return $contents;
			break;
		case TEMPLATE_INCLUDEPATH:
			return $compile;
			break;
	}
}

/**
 * [template_compile 解析模板]
 * @param  [type]  $from     [被解析文件]
 * @param  [type]  $to       [解析为]
 * @param  boolean $inmodule [如果您还想在 include_path（在 php.ini 
 *                           中）中搜索文件的话，请设置该参数为 '1']
 * @return  boolean          [成功/失败]
 */
function template_compile($from, $to, $inmodule = false) {
	$path = dirname($to);
	// 开始解析
	$content = template_parse(file_get_contents($from), $inmodule);
	// 如果有需求可以进一步加工
	if(preg_match('/(footer|header|account\/welcome|login|register)+/', $from)) {
		// $content = str_replace('系统', '系统', $content);
	}
	file_put_contents($to, $content);
}

/**
 * [template_parse 解析html模板为php脚本定界符为{}后边可拓展]
 * @param  [type]  $str      [需要解析的html内的字符串]
 * @param  boolean $inmodule [如果您还想在 include_path（在 php.ini 
 *                           中）中搜索文件的话，请设置该参数为 '1']
 * @return [string]          [解析后的字符串]
 */
function template_parse($str, $inmodule = false) {
	// 原样输出<!--{ }-->中的内容
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);

	// 如果有引入文件{teplate $1}先进行解析引入
	$str = preg_replace('/{template\s+(.+?)}/', '<?php  (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);

	// 原样输出{php $1}中经过php解析的内容
	$str = preg_replace('/{php\s+(.+?)}/', '<?php $1?>', $str);

	// if else elseif 循环语句 解析{if $1}{elseif $1}{/if}
	$str = preg_replace('/{if\s+(.+?)}/', '<?php if($1) { ?>', $str);
	$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
	$str = preg_replace('/{else ?if\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
	$str = preg_replace('/{\/if}/', '<?php } ?>', $str);

	// foreach循环语句解析{loop $1 $2 [$3]}{/loop}
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
	$str = preg_replace('/{\/loop}/', '<?php } } ?>', $str);

	// 解析并打印php变量{^$1}
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\[\]\'\"\$]*)}/', '<?php echo $1;?>', $str);

	// 解析url变量{url $1 [$2]} url()函数后边可自定义
	$str = preg_replace('/{url\s+(\S+)}/', '<?php echo url($1);?>', $str);
	$str = preg_replace('/{url\s+(\S+)\s+(array\(.+?\))}/', '<?php echo url($1, $2);?>', $str);

	// 转化为媒体控件
	$str = preg_replace('/{media\s+(\S+)}/', '<?php echo tomedia($1);?>', $str);
	// 处理php标签
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "template_addquote", $str);
	// {}里的内容原样输出
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	// 将{##[]##}输出为{}
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	// 解析完之后可以进一步操作
	return $str;
}

function template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}