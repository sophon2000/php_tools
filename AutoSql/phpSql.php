<?php 
/**
 * 自动读取sql文件并操作
 */
require 'config.php';
// 获取SQL文件
$installfile = './test.sql';
$fp = fopen($installfile, 'rb');
$sql = fread($fp, filesize($installfile));
fclose($fp);

// 数据库配置
$db_charset = $db_config['db_charset'];
$db_prefix = $db_config['db_prefix']; 
// 格式化sql文件
$sql = str_replace("\r", "\n", str_replace('`'.'ts_', '`'.$db_prefix, $sql));

// 连接数据库
mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
// 获得mysql版本
$sqlv = mysql_get_server_info();
if (version_compare($sqlv, '5.0.0', '>')) {
    mysql_query("SET sql_mode = ''");
}

mysql_query("SET character_set_connection={$db_config['db_charset']}, character_set_results={$db_config['db_charset']}, character_set_client=binary");
$db_charset = (strpos($db_charset, '-') === false) ? $db_charset : str_replace('-', '', $db_charset);
mysql_query(" CREATE DATABASE IF NOT EXISTS `{$db_config['db_name']}` DEFAULT CHARACTER SET $db_charset ");
// 成功与否
if (mysql_errno()) {
    echo $errormsg = mysql_error();
} else {
    mysql_select_db($db_config['db_name']);
}

//判断是否有用同样的数据库前缀安装过
$re = mysql_query("SELECT COUNT(1) FROM {$db_config['db_prefix']}user");
$link = @mysql_fetch_row($re);
if (intval($link[0]) > 0) {
    echo '前缀重复';
}

// 入库
$tablenum = 0;
foreach (explode(";\n", trim($sql)) as $query) {
    $query = trim($query);
    if ($query) {
        if (substr($query, 0, 12) == 'CREATE TABLE') {
            // 表名
            $name = preg_replace('/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is', '\\2', $query);
            echo $name.'表创建成功';
            @mysql_query(createtable($query, $db_charset));
            $tablenum++;
        } else {
            @mysql_query($query);
        }
    }
} 

echo '成功';
echo '新建'.$tablenum.'张表';