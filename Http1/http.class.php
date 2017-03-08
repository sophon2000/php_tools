<?php 
interface Proto
{
	// 连接url
	function conn($url);

	// 发送get查询
	function get();

	// 发送 post查询
	function post();

	// 关闭连接
	function close();
}
class Http implements proto
{
	const GRLF ="\r\n";

	protected $errno = -1;
	protected $errstr = '';
	protected $response = '';

	protected $url = array();
	protected $version = 'HTTP/1.1';
	protected $fh= null;

	protected $line = array();
	protected $header = array();
	protected $body = array();


	public function __construct($url)
	{
		$this->conn($url);
		$this->setHearder('Host: '.$this->url['host']);
	}

	// 此方法负责写请求行
	protected function setLine($method)
	{
		$this->line[0] = $method.' '.$this->url['path'].'?'.$this->url['query'].' '.$this->version;
	}

	// 此方法负责写头信息
	protected function setHearder($headerLine)
	{
		$this->header[] = $headerLine;
	}

	// 此方法负责写主体信息
	protected function setBody($body)
	{
		$this->body[] = http_build_query($body);
	}

	// 连接url
	public function conn($url)
	{
		$this->url = parse_url($url);
		// 判断端口
		if(!isset($this->url['port'])){
			$this->url['port'] = 80;
		}
		// 判断端口
		if(!isset($this->url['query'])){
			$this->url['query'] = '';
		}
		$this->fh = fsockopen($this->url['host'],$this->url['port'],$this->errno,$this->errstr,5);
	}

	// 構造get親求數據
	public function get()
	{
		$this->setLine('GET');
		$this->request();
		return $this->response;
	}


	// 构造post请求数据
	public function post($body=array())
	{
		$this->setLine('POST');
		// 设置content-type
		$this->setHearder('Content-type: application/x-www-forn-urlencoded');
		// 构造主体信息
		$this->setBody($body);
		// 计算content-length
		$this->setHearder('Content-length: '.strlen($this->body[0]));
		$this->request();

	}

	// 真正求求
	public function request()
	{
		$req = array_merge($this->line,$this->header,array(''),$this->body,array(''));
		$req = implode(self::GRLF, $req);
		fwrite($this->fh, $req);
		while(!feof($this->fh)){
			$this->response .= fread($this->fh,1024);
		}
		$this->close();
	}



	// 关闭连接
	public function close()
	{
		fclose($this->fh);
	}
}

