<?php
/**
 * 一个遵循PSR-4的文件自动加载类
 */

abstract class AutoloadRoot
{
	// 注册自动加载函数到spl autoload栈中
	abstract public function register();

	// 添加一个目录到一个命名空间前缀中
	abstract public function addNamespace($prefix, $base_dir, $prepend=false);

	// 自动加载函数，会在$this->register中用到
	abstract public function loadClass($class);

	// 寻找映射的文件
	abstract public function loadMappedFile($prefix, $relative_class);

	//查看一个文件是否在文件系统中存在
	abstract public function requireFile($file);

}

 class Autoload extents AutoloadRoot
{
	// 注册自动加载函数到spl autoload栈中
	public function register()
	{
		
	}

	// 添加一个目录到一个命名空间前缀中
	public function addNamespace($prefix, $base_dir, $prepend=false)
	{
		
	}

	// 自动加载函数，会在$this->register中用到
	public function loadClass($class)
	{
		 // 当前的命名空间前缀
         $prefix = $class;
         
         //通过命名空间去查找对应的文件
         while (false !== $pos = strrpos($prefix, ‘\\‘)) {
             
             // 可能存在的命名空间前缀
             $prefix = substr($class, 0, $pos + 1);
 
             // 剩余部分是可能存在的类
             $relative_class = substr($class, $pos + 1);

             //试图加载prefix前缀和relitive class对应的文件
             $mapped_file = $this->loadMappedFile($prefix, $relative_class);
             if ($mapped_file) {
                 return $mapped_file;
             }
 
             // 移动命名空间和relative class分割位置到下一个位置
             $prefix = rtrim($prefix, ‘\\‘);   
         }
         
         // 未找到试图加载的文件
         return false;
	}

	// 寻找映射的文件
	public function loadMappedFile($prefix, $relative_class)
	{
		
	}

	//查看一个文件是否在文件系统中存在
	public function requireFile($file)
	{
		
	}

}