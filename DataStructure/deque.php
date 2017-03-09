<?php
class Deque  
{ 
    public $queue = array(); 
    
    /**（尾部）入队  **/ 
    public function addLast($value)  
    { 
        return array_push($this->queue,$value); 
    } 
    /**（尾部）出队**/ 
    public function removeLast()  
    { 
        return array_pop($this->queue); 
    } 
    /**（头部）入队**/ 
    public function addFirst($value)  
    { 
        return array_unshift($this->queue,$value); 
    } 
    /**（头部）出队**/ 
    public function removeFirst()  
    { 
        return array_shift($this->queue); 
    } 
    /**清空队列**/ 
    public function makeEmpty()  
    { 
        unset($this->queue);
    } 
    
    /**获取列头**/
    public function getFirst()  
    { 
        return reset($this->queue); 
    } 
 
    /** 获取列尾 **/
    public function getLast()  
    { 
        return end($this->queue); 
    }
 
    /** 获取长度 **/
    public function getLength()  
    { 
        return count($this->queue); 
    }
    
}
