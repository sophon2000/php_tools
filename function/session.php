<?php
/**
 * 自定义SESSION类
 */

/*
存储session 的表
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `sid` char(32) NOT NULL,
  `data` varchar(5000) NOT NULL,
  `expiretime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */

class mySession {
	
	
	public static $expire;

	
	public static function start($uniacid, $openid, $expire = 3600) {
		WeSession::$expire = $expire;
		$sess = new mySession();
		session_set_save_handler(
			array(&$sess, 'open'),
			array(&$sess, 'close'),
			array(&$sess, 'read'),
			array(&$sess, 'write'),
			array(&$sess, 'destroy'),
			array(&$sess, 'gc')
		);
		register_shutdown_function('session_write_close');
		session_start();
	}

	public function open() {
		return true;
	}

	public function close() {
		return true;
	}

	
	public function read($sessionid) {
		$sql = 'SELECT * FROM ' . tablename('sessions') . ' WHERE `sid`=:sessid AND `expiretime`>:time';
		$params = array();
		$params[':sessid'] = $sessionid;
		$params[':time'] = time();
		$row = pdo_fetch($sql, $params);
		if(is_array($row) && !empty($row['data'])) {
			return $row['data'];
		}
		return false;
	}

	
	public function write($sessionid, $data) {
		$row = array();
		$row['sid'] = $sessionid;
		$row['data'] = $data;
		$row['expiretime'] = time() + WeSession::$expire;
		return pdo_insert('sessions', $row, true) >= 1;
	}

	
	public function destroy($sessionid) {
		$row = array();
		$row['sid'] = $sessionid;

		return pdo_delete('sessions', $row) == 1;
	}

	
	public function gc($expire) {
		$sql = 'DELETE FROM ' . tablename('sessions') . ' WHERE `expiretime`<:expire';

		return pdo_query($sql, array(':expire' => TIMESTAMP)) == 1;
	}
}