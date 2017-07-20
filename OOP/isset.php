<?php

/**
 * isset in obj
 */

class Model
{
    // 存放属性
    protected $attributes = [];

    // 存放关系
    protected $relations = [];

    public function __get($key)
    {
        if( isset($this->attributes[$key]) ) {
            return $this->attributes[$key];
        }

          // 找到关联的对象，放在关系里面
        if (method_exists($this, $key)) {
              $relation = $this->$key();   

              return $this->relations[$key] = $relation;
        }
    }

    public function __set($k, $v)
    {
        $this->attributes[$k] = $v;
    }

    public function __isset($key)
    {
        if (isset($this->attributes[$key]) || isset($this->relations[$key])) {
            return true;
        }

        return false;
    }
}

class Post extends Model
{

    protected function user()
    {
        $user = new User();
        $user->name = 'user name';
        return $user;
    }

}

class User extends Model
{
}

$post = new Post();

// echo 'isset 发帖用户：';
// echo isset($post->user) ? 'true' : 'false';  // false
// var_dump($post->user);
// echo PHP_EOL;
// echo 'isset 发帖用户的名字：';
echo isset($post->user->name) ? 'true' : 'false';  // false
echo $post->user->name;
echo PHP_EOL;
echo '发帖用户的名字：';
echo $post->user->name;    // user name
echo PHP_EOL;

echo '再次判断 isset 发帖用户的名字：';
echo isset($post->user->name) ? 'true' : 'false';   // true
echo PHP_EOL;


