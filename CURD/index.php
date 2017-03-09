<?php
// 模拟增删改查
abstract class CURD
{
	// 增加元素
	abstract function add();
	// 插入元素
	abstract function insert();
	// 删除元素
	abstract function delete($id);
	// 通过ID查找
	abstract function findById($id);
	// 通过内容查找
	abstract function findByCon($con);
	// 遍历内容
	abstract function doList();
}

class doCURD extends CURD 
{
	// 数据
	public $key  = null;
	public $name = null;
	public $age  = null;
	// 节点数量
	public $length = '';

	public function __construct()
	{
		for ($i=1; $i <= 25; $i++) { 
			$this->key[]  = $i;
			$this->name[] =  chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90));
			$this->age[]  =  rand(0,100);
		}
	}
	// 增加元素
	public function add()
	{

	}
	// 插入元素
	public function insert()
	{

	}
	// 删除元素
	public function delete($id)
	{
		$count=count($this->key);
		$key  = $this->key;
		$name = $this->name;
		$age  = $this->age;
		for ($i=$count-2; $i >=$id-1; $i--) {
			if ($this->) {
				# code...
			}
			$this->key[$i] = $key[$i+1];
			$this->name[$i] = $name[$i+1];
			$this->age[$i] = $age[$i+1];
		}
		var_dump($this->key);
	}
	// 通过ID查找
	public function findById($id)
	{
		for ($i=0; $i < count($this->key); $i++) { 
			$check[0] = $this->key[$i];
			$check[1] = $this->name[$i];
			$check[2] = $this->age[$i];
			if ($id == $check[0]) {
				echo implode(' ', $check);
				break 1 ;
			}
		}
	}
	// 通过内容查找
	public function findByCon($con)
	{
		for ($i=0; $i < count($this->key); $i++) { 
			$check[0] = $this->key[$i];
			$check[1] = $this->name[$i];
			$check[2] = $this->age[$i];
			if (in_array($con, $check)) {
				echo implode(' ', $check);
				break 1 ;
			}
		}

	}
	// 遍历内容
	public function doList()
	{
		for ($i=0; $i < count($this->key); $i++) { 
			echo $this->key[$i].' ';
			echo $this->name[$i].' ';
			echo $this->age[$i].'<br>';
		}
	}

}

$ob = new doCURD;
// $ob->doList();
// $ob->findByCon(8);
// $ob->findById(8);
$ob->delete(8);