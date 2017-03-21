<?php 
/**
 * An Example For Smarty
 */
require '../vendor/autoload.php';

$smarty = new Smarty();

$smarty->config_dir="Smarty/Config_File.class.php";  // 目录变量
$smarty->template_dir = "./templates";               //设置模板目录
$smarty->compile_dir = "./templates_c";              //设置编译目录
$smarty->cache_dir = "./smarty_cache";               //缓存文件夹

$smarty->caching = true;                             //开启缓存,为flase的时侯缓存无效  
$smarty->cache_lifetime = 60;                        //缓存时间  
$smarty->clear_all_cache();                          //清除所有缓存  
$smarty->clear_cache('index.htm');                   //清除index.tpl的缓存  
$smarty->clear_cache('index.htm',$cache_id);         //清除指定id的缓存 

$smarty->display('cache.tpl', $cache_id);            //创建带ID的缓存  
$smarty ->left_delimiter = "{";                      //左定界符 
$smarty ->right_delimiter = "}";                     //右定界符 

/*
常用变量操作符{$name|capitalize } 
	capitalize [首字母大写] 
	count_characters [计算字符数] 
	cat [连接字符串] 
	count_paragraphs [计算段落数]
	count_sentences [计算句数]
	count_words [计算词数]
	date_format [时间格式]
	default [默认]
	escape [转码]
	indent[缩进]
	lower[小写 ]
	nl2br[换行符替换成<br />]
	regex_replace[正则替换]
	replace[替换]
	spacify[插空]
	string_format[字符串格式化]
	strip[去除(多余空格)]
	strip_tags[去除html标签]
	truncate[截取]
	upper[大写]
	wordwrap[行宽约束]

判断
	{if $name=='ok'}

	{else}

	{/if}

循环
	{foreach from=$name item=id}  
	{$id}  
	{/foreach}  
	    或  
	{foreach key=j item=v from=$name }  
	{$j}: {$v}  
	{/foreach}  

包含
	{include file="header.htm"}

当文本输出
	{literal}  
	     <script language=javascript>  
	     </script>  
	{/literal}  
 */