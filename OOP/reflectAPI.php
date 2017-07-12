<?php 

class Person
{
	public $name;
	public $age;

	public function say()
	{
		echo $this->name.' '.$this->age;
	}

	public function __set($name,$arguments)
	{
		$this->$name=$value;
	}

	public function __get($name)
	{
		if(!isset($this->$name)){
			$this->$name='默认值';
		}
		return $this->$name;
	}
}

$student = new person();
$student->name = 'Tom';
$student->gender = 'male';
$student->age = 24;

$reflect = new ReflectionObject($student);
// $reflect = new ReflectionClass(Person);
// $method = $reflect->getMethod($name);
// $method->invoke($student,$args);
// 获取对象属性
$props = $reflect->getproperties();
foreach ($props as $prop) {
	print $prop->getName().'<br>';
}
// 获取对象方法
$m = $reflect->getMethods();
foreach ($m as $prop) {
	// $prop->isPublic isPrivate isProtected isStatic isAbstract
	print $prop->getName().'<br>';
}
$className = get_class($student);
echo $className,'<br>';
$methods = get_class_methods(Person);
print_r($methods);
$vars = get_class_vars(Person);
print_r($vars);
echo '<br>---------------------------------------------<br>';
$i = get_object_vars($student);
print_r($i);


// 获得父类名
// $parent = get_parent_class()