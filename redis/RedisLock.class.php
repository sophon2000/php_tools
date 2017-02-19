<?php 
/**
 * Redis 锁操作类
 * Func
 * lock 获取锁
 * unlock 释放锁
 * connect 连接
 */
class RedisLock
{
	private $_config;
	private $_redis;

	public function __construct($config=array())
	{
		$this->_config = $config;
		$this->_redis = $this->connect();
	}

	/**
	 * 获取锁
	 * @param  string  $key    锁标识
	 * @param  integer $expire 过期时间
	 * @return Boolean          
	 */
	public function lock($key,$expire=5)
	{
		$is_lock = $this->_redis->setnx($key,time()+$expire);
		if(!$is_lock){
			$lock_time = $this->_redis->get($key);
			if (time()>$lock_time) {
				$this->unlock($key);
				$is_lock = $this->_redis->setnx($key,time()+$expire);
			}
		}
		return $is_lock?true:false;
	}

	/**
	 * 释放锁
	 * @param  string $key 锁标识
	 * @return Boolean      
	 */
	public function unlock($key)
	{
		return $this->_redis->del($key);
	}


	public function connect()
	{
		try {
			$redis = new Redis();
			$redis->connect(
				$this->_config['host'],
				$this->_config['port'],
				$this->_config['timeout'],
				$this->_config['reserved'],
				$this->_config['retry_interval']
				);
			if(empty($this->config['auth'])){
				$redis->auth($this->_config['auth']);
			}
			$redis->select($this->_config['index']);
		} catch (RedisException $e) {
			throw new Exception($e->getMessage());
			return false;
			
		}
		return $redis;
	}
}