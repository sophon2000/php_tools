<?php 
/**
 *数据库配置
 */

$db_config['db_charset']  ='utf-8';
$db_config['db_prefix']   ='ts_';
$db_config['db_host']     ='127.0.0.1';
$db_config['db_username'] ='root';
$db_config['db_password'] ='';
$db_config['db_name']     = 'test';

/**
 * [createtable 新建表预处理]
 * @param  [type] $sql        [description]
 * @param  [type] $db_charset [description]
 * @return [type]             [description]
 */
function createtable($sql, $db_charset)
{
    $db_charset = (strpos($db_charset, '-') === false) ? $db_charset : str_replace('-', '', $db_charset);
    $type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", '\\2', $sql));
    $type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';

    return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", '\\1', $sql).
        (mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$db_charset" : " TYPE=$type");
}