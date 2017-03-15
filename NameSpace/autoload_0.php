<?php 
/**
 * 一个遵循PSR-0的文件自动加载函数
 */

// 定义系统目录分割符号
echo DIRECTORY_SEPARATOR;

function autoload($className)  
{  
    $className = ltrim($className, '\\');  
    $fileName  = '';  
    $namespace = '';  
    if ($lastNsPos = strrpos($className, '\\')) {  
        $namespace = substr($className, 0, $lastNsPos);  
        $className = substr($className, $lastNsPos + 1);  
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;  
    }  
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';  
  
    require $fileName;  
}  
spl_autoload_register('autoload');  