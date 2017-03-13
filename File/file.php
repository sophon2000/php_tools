<?php
/**
 * 文件操作类
 * 
 */



/**
 * [file_write 将数据写入文件]
 * @param  [string] $filename [文件名称带路径]
 * @param  [string] $data     [写入数据]
 * @param  [string] $chomd     []
 * @return [type]           [将数据 $data 写入到文件 $filename 中，如果文件 $filename
 *                            不存在，则创建，返回一个是否写入成功的布尔值]
 */
function file_write($filename, $data,$chomd = 0755) {
	mkdirs(dirname($filename));
	file_put_contents($filename, $data);
	@chmod($filename, $chomd);
	return is_file($filename);
}

function file_read($filename) {
	global $_W;
	$filename = ATTACHMENT_ROOT . '/' . $filename;
	if (!is_file($filename)) {
		return false;
	}
	return file_get_contents($filename);
}



/**
 * [file_move 将文件移动至目标位置]
 * @param  [string]  $filename [移动的文件]
 * @param  [string]  $dest     [移动的目标位置]
 * @param  integer $chomd    [description]
 * @return [type]            [将指定文件移动到指定的目录，如果目录不
 *         		            存在，则创建，返回一个是否移动成功的布尔值]
 */
function file_move($filename, $dest,$chomd = 0755) {
	mkdirs(dirname($dest));
	if (is_uploaded_file($filename)) {
		move_uploaded_file($filename, $dest);
	} else {
		rename($filename, $dest);
	}
	@chmod($filename, $chomd);
	return is_file($dest);
}



/**
 * [file_tree 获取指定目录下所有文件路径]
 * @param  [string] $path [文件夹目录]
 * @return [type]       [获取并返回 $path 目录下所有文件数组]
 */
function file_tree($path) {
	$files = array();
	$ds = glob($path . '/*');
	if (is_array($ds)) {
		foreach ($ds as $entry) {
			if (is_file($entry)) {
				$files[] = $entry;
			}
			if (is_dir($entry)) {
				$rs = file_tree($entry);
				foreach ($rs as $f) {
					$files[] = $f;
				}
			}
		}
	}
	return $files;
}



/**
 * [mkdirs 递归创建目录]
 * @param  [string] $path [需要创建的目录名称]
 * @return [type]       [根据参数创建对应的目录，并返回一个是否创建成功的布尔值]
 */
function mkdirs($path) {
	if (!is_dir($path)) {
		mkdirs(dirname($path));
		mkdir($path);
	}
	return is_dir($path);
}



/**
 * [file_copy 复制指定目录下所有文件到新目录]
 * @param  [string] $src    [原始文件夹]
 * @param  [string] $des    [目标文件夹]
 * @param  [array] $filter  [需要过滤的文件类型]
 * @return [type]           [description]
 */
function file_copy($src, $des, $filter) {
	$dir = opendir($src);
	@mkdir($des);
	while (false !== ($file = readdir($dir))) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				file_copy($src . '/' . $file, $des . '/' . $file, $filter);
			} elseif (!in_array(substr($file, strrpos($file, '.') + 1), $filter)) {
				copy($src . '/' . $file, $des . '/' . $file);
			}
		}
	}
	closedir($dir);
}

/**
 * [rmdirs 删除目录]
 * @param  [string]  $path  [目录位置]
 * @param  boolean $clean [是否删除整个目录]
 * @return [type]         [如果参数 $clean 为 true，则不删除目录，仅删除目录内文件; 否则删除整个目录]
 */
function rmdirs($path, $clean = false) {
	if (!is_dir($path)) {
		return false;
	}
	$files = glob($path . '/*');
	if ($files) {
		foreach ($files as $file) {
			is_dir($file) ? rmdirs($file) : @unlink($file);
		}
	}
	return $clean ? true : @rmdir($path);
}



/**
 * [file_upload 上传文件到附件目录]
 * @param  [array] $file [上传的文件信息]
 * @param  string $type [文件保存类型]
 * @param  string $name [保存的文件名，如果为空则自动生成]
 * @return [type]       [返回上传的结果，如果失败，返回错误数组，
 *         				否则返回上传成功信息及保存的文件路径]
 */
function file_upload($file, $type = 'image', $name = '') {
	$harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
	if (empty($file)) {
		return array(-1, '没有上传内容');
	}
	if (!in_array($type, array('image', 'thumb', 'voice', 'video', 'audio'))) {
		return array(-2, '未知的上传类型');
	}

	global $_W;
	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	switch($type){
		case 'image':
		case 'thumb':
			$allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico');
			$limit = 4 * 1024;
			break;
		case 'voice':
		case 'audio':
			$allowExt = array('mp3', 'wma', 'wav', 'amr');
			$limit = 6 * 1024;
			break;
		case 'video':
			$allowExt = array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4');
			$limit = 20 * 1024;
			break;
	}
	$setting = $_W['setting']['upload'][$type];
	if(!empty($setting)){
		$allowExt = array_merge($setting['extentions'], $allowExt);
	}
	if (!in_array(strtolower($ext), $allowExt) || in_array(strtolower($ext), $harmtype)) {
		return array(-3, '不允许上传此类文件');
	}
	if (!empty($limit) && $limit * 1024 < filesize($file['tmp_name'])) {
		return array(-4, "上传的文件超过大小限制，请上传小于 {$limit}k 的文件");
	}
	$result = array();
	if (empty($name) || $name == 'auto') {
		$uniacid = intval($_W['uniacid']);
		$path = "{$type}s/{$uniacid}/" . date('Y/m/');
		mkdirs(ATTACHMENT_ROOT . '/' . $path);
		$filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);

		$result['path'] = $path . $filename;
	} else {
		mkdirs(dirname(ATTACHMENT_ROOT . '/' . $name));
		if (!strexists($name, $ext)) {
			$name .= '.' . $ext;
		}
		$result['path'] = $name;
	}

	if (!file_move($file['tmp_name'], ATTACHMENT_ROOT . '/' . $result['path'])) {
		return array(-1, '保存上传文件失败');
	}
	$result['success'] = true;
	return $result;
}

function file_wechat_upload($file, $type = 'image', $name = '') {
	$harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
	if (empty($file)) {
		return array(-1, '没有上传内容');
	}
	if (!in_array($type, array('image', 'thumb', 'voice', 'video', 'audio'))) {
		return array(-2, '未知的上传类型');
	}
	
	global $_W;
	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	if (in_array(strtolower($ext), $harmtype)) {
		return array(-3, '不允许上传此类文件');
	}

	$result = array();
	if (empty($name) || $name == 'auto') {
		$uniacid = intval($_W['uniacid']);
		$path = "{$type}s/{$uniacid}/" . date('Y/m/');
		mkdirs(ATTACHMENT_ROOT . '/' . $path);
		$filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);
		$result['path'] = $path . $filename;
	} else {
		mkdirs(dirname(ATTACHMENT_ROOT . '/' . $name));
		if (!strexists($name, $ext)) {
			$name .= '.' . $ext;
		}
		$result['path'] = $name;
	}
	
	if (!file_move($file['tmp_name'], ATTACHMENT_ROOT . '/' . $result['path'])) {
		return array(-1, '保存上传文件失败');
	}
	$result['success'] = true;
	return $result;
}



function file_remote_upload($filename, $auto_delete_local = true) {
	global $_W;
	if (empty($_W['setting']['remote']['type'])) {
		return false;
	}
	if ($_W['setting']['remote']['type'] == '1') {
		require_once(IA_ROOT . '/framework/library/ftp/ftp.php');
		$ftp_config = array(
			'hostname' => $_W['setting']['remote']['ftp']['host'],
			'username' => $_W['setting']['remote']['ftp']['username'],
			'password' => $_W['setting']['remote']['ftp']['password'],
			'port' => $_W['setting']['remote']['ftp']['port'],
			'ssl' => $_W['setting']['remote']['ftp']['ssl'],
			'passive' => $_W['setting']['remote']['ftp']['pasv'],
			'timeout' => $_W['setting']['remote']['ftp']['timeout'],
			'rootdir' => $_W['setting']['remote']['ftp']['dir'],
		);
		$ftp = new Ftp($ftp_config);
		if (true === $ftp->connect()) {
			$response = $ftp->upload(ATTACHMENT_ROOT . '/' . $filename, $filename);
			if ($auto_delete_local) {
				file_delete($filename);
			}
			if (!empty($response)) {
				return true;
			} else {
				return array(1, '远程附件上传失败，请检查配置并重新上传');
			}
		} else {
			return array(1, '远程附件上传失败，请检查配置并重新上传');
		}
	} elseif ($_W['setting']['remote']['type'] == '2') {
		require_once(IA_ROOT.'/framework/library/alioss/autoload.php');
		load()->model('attachment');
		$buckets = attachment_alioss_buctkets($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret']);
		$endpoint = 'http://'.$buckets[$_W['setting']['remote']['alioss']['bucket']]['location'].'.aliyuncs.com';
		try {
			$ossClient = new \OSS\OssClient($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret'], $endpoint);
			$ossClient->uploadFile($_W['setting']['remote']['alioss']['bucket'], $filename, ATTACHMENT_ROOT.$filename);
		} catch (\OSS\Core\OssException $e) {
			return array(1, $e->getMessage());
		}
		if ($auto_delete_local) {
			file_delete($filename);
		}
	}elseif ($_W['setting']['remote']['type'] == '3') {
		require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
		$auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'],$_W['setting']['remote']['qiniu']['secretkey']);
		$zone = $_W['setting']['remote']['qiniu']['district'] == 1 ?  Qiniu\Zone::zone0() : Qiniu\Zone::zone1();
		$config = new Qiniu\Config($zone);
		$uploadmgr = new Qiniu\Storage\UploadManager($config);
		$putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array('scope' => $_W['setting']['remote']['qiniu']['bucket'].':'. $filename)));
		$uploadtoken = $auth->uploadToken($_W['setting']['remote']['qiniu']['bucket'], $filename, 3600, $putpolicy);
		list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, ATTACHMENT_ROOT. '/'.$filename);
		if ($auto_delete_local) {
			file_delete($filename);
		}
		if ($err !== null) {
			return array(1, '远程附件上传失败，请检查配置并重新上传');
		} else {
			return true;
		}
	} elseif ($_W['setting']['remote']['type'] == '4') {
		require(IA_ROOT.'/framework/library/cos/include.php');
		$uploadRet = \Qcloud_cos\Cosapi::upload($_W['setting']['remote']['cos']['bucket'], ATTACHMENT_ROOT .$filename,'/'.$filename,'',3 * 1024 * 1024, 0);
		if ($uploadRet['code'] != 0) {
			switch ($uploadRet['code']) {
				case -62:
					$message = '输入的appid有误';
					break;
				case -79:
					$message = '输入的SecretID有误';
					break;
				case -97:
					$message = '输入的SecretKEY有误';
					break;
				case -166:
					$message = '输入的bucket有误';
					break;
			}
			return array(-1, $message);
		}
	}
}



/**
 * [file_random_name 获取指定某目录下指定后缀的随机文件名]
 * @param  [string] $dir [目录的绝对路径]
 * @param  [string] $ext [文件后缀名]
 * @return [type]      [返回获取到的随机文件名称]
 */
function file_random_name($dir, $ext){
	do {
		$filename = random(30) . '.' . $ext;
	} while (file_exists($dir . $filename));

	return $filename;
}


/**
 * [file_delete 删除文件]
 * @param  [stirng] $file [需要删除的文件名]
 * @param  [mixed] $file [附件目录]
 * @return [blooean]      [删除成功返回 true， 失败返回 false]
 */
function file_delete($file,$attachment=false) {
	if (empty($file)) {
		return FALSE;
	}
	if (file_exists($file)) {
		@unlink($file);
	}
	if ($attachment) {
		if (file_exists($attachment . '/' . $file)) {
			@unlink($attachment . '/' . $file);
		}
	}
	return TRUE;
}

function file_remote_delete($file) {
	global $_W;
	if(empty($file)) {
		return true;
	}
	if ($_W['setting']['remote']['type'] == '1') {
		require_once(IA_ROOT . '/framework/library/ftp/ftp.php');
		$ftp_config = array(
			'hostname' => $_W['setting']['remote']['ftp']['host'],
			'username' => $_W['setting']['remote']['ftp']['username'],
			'password' => $_W['setting']['remote']['ftp']['password'],
			'port' => $_W['setting']['remote']['ftp']['port'],
			'ssl' => $_W['setting']['remote']['ftp']['ssl'],
			'passive' => $_W['setting']['remote']['ftp']['pasv'],
			'timeout' => $_W['setting']['remote']['ftp']['timeout'],
			'rootdir' => $_W['setting']['remote']['ftp']['dir'],
		);
		$ftp = new Ftp($ftp_config);
		if (true === $ftp->connect()) {
			if ($ftp->delete_file($file)) {
				return true;
			} else {
				return array(1, '删除附件失败，请检查配置并重新删除');
			}
		} else {
			return array(1, '删除附件失败，请检查配置并重新删除');
		}
	} elseif ($_W['setting']['remote']['type'] == '2') {
		load()->model('attachment');
		require_once(IA_ROOT.'/framework/library/alioss/autoload.php');
		$buckets = attachment_alioss_buctkets($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret']);
		$endpoint = 'http://'.$buckets[$_W['setting']['remote']['alioss']['bucket']]['location'].'.aliyuncs.com';
		try {
			$ossClient = new \OSS\OssClient($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret'], $endpoint);
			$ossClient->deleteObject($_W['setting']['remote']['alioss']['bucket'], $file);
		} catch (\OSS\Core\OssException $e) {
			return array(1, '删除oss远程文件失败');
		}
	}  elseif ($_W['setting']['remote']['type'] == '3') {
		require_once IA_ROOT . '/framework/library/qiniu/autoload.php';
		$auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'], $_W['setting']['remote']['qiniu']['secretkey']);
		$bucketMgr = new Qiniu\Storage\BucketManager($auth);
		$error = $bucketMgr->delete($_W['setting']['remote']['qiniu']['bucket'], $file);
		if ($error instanceof Qiniu\Http\Error) {
			if ($error->code() == 612) {
				return true;
			}
			return error(1, '删除七牛远程文件失败');
		} else {
			return true;
		}
	}  elseif ($_W['setting']['remote']['type'] == '4') {
		require(IA_ROOT.'/framework/library/cos/include.php');
		$bucketName = $_W['setting']['remote']['cos']['bucket'];
		$path = "/".$file;
		$result = Qcloud_cos\Cosapi::delFile($bucketName, $path);
		if (!empty($result['code'])) {
			return error(-1, '删除cos远程文件失败');
		} else {
			return true;
		}
	}
	return true;
}


/**
 * [file_image_thumb 图像缩略处理]
 * @param  string  $srcfile [需要缩略的图像]
 * @param  string  $desfile [缩略完成后的图像]
 * @param  integer $width   [缩放宽度]
 * @return [type]           [如果图像缩略成功，则返回缩略图的地址，否则返回错误信息数组]
 */
function file_image_thumb($srcfile, $desfile = '', $width = 0) {
	global $_W;

	if (!file_exists($srcfile)) {
		return array('-1', '原图像不存在');
	}
	if (!file_is_image($srcfile)) {
		return array('-1', '原图像不存在');
	}
	if (intval($width) == 0) {
		load()->model('setting');
		$width = intval($_W['setting']['upload']['image']['width']);
	}
	if (intval($width) < 0) {
		return array('-1', '缩放宽度无效');
	}

	if (empty($desfile)) {
		$ext = pathinfo($srcfile, PATHINFO_EXTENSION);
		$srcdir = dirname($srcfile);
		do {
			$desfile = $srcdir . '/' . random(30) . ".{$ext}";
		} while (file_exists($desfile));
	}

	$des = dirname($desfile);
		if (!file_exists($des)) {
		if (!mkdirs($des)) {
			return array('-1', '创建目录失败');
		}
	} elseif (!is_writable($des)) {
		return array('-1', '目录无法写入');
	}

		$org_info = @getimagesize($srcfile);
	if ($org_info) {
		if ($width == 0 || $width > $org_info[0]) {
			copy($srcfile, $desfile);
			return str_replace(ATTACHMENT_ROOT . '/', '', $desfile);
		}
		if ($org_info[2] == 1) { 			if (function_exists("imagecreatefromgif")) {
				$img_org = imagecreatefromgif($srcfile);
			}
		} elseif ($org_info[2] == 2) {
			if (function_exists("imagecreatefromjpeg")) {
				$img_org = imagecreatefromjpeg($srcfile);
			}
		} elseif ($org_info[2] == 3) {
			if (function_exists("imagecreatefrompng")) {
				$img_org = imagecreatefrompng($srcfile);
				imagesavealpha($img_org, true);
			}
		}
	} else {
		return array('-1', '获取原始图像信息失败');
	}
		$scale_org = $org_info[0] / $org_info[1];
		$height = $width / $scale_org;
	if (function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$img_dst = imagecreatetruecolor($width, $height)) {
		imagealphablending($img_dst, false);
		imagesavealpha($img_dst, true);
		imagecopyresampled($img_dst, $img_org, 0, 0, 0, 0, $width, $height, $org_info[0], $org_info[1]);
	} else {
		return array('-1', 'PHP环境不支持图片处理');
	}
	if ($org_info[2] == 2) {
		if (function_exists('imagejpeg')) {
			imagejpeg($img_dst, $desfile);
		}
	} else {
		if (function_exists('imagepng')) {
			imagepng($img_dst, $desfile);
		}
	}

	imagedestroy($img_dst);
	imagedestroy($img_org);

	return str_replace(ATTACHMENT_ROOT . '/', '', $desfile);
}




/**
 * [file_image_crop 图像裁切处理]
 * @param  [string]  $src      [原图像地址]
 * @param  [string]  $desfile  [新图像地址]
 * @param  integer $width      [要裁切的宽度]
 * @param  integer $height     [要裁切的高度]
 * @param  integer $position   [开始裁切的位置， 按照九宫格1-9指定位置]
 * @return [type]              [如果图像裁切成功，返回 true，否则返回错误信息数组]
 */
function file_image_crop($src, $desfile, $width = 400, $height = 300, $position = 1) {
	if (!file_exists($src)) {
		return error('-1', '原图像不存在');
	}
	if (intval($width) <= 0 || intval($height) <= 0) {
		return error('-1', '裁剪尺寸无效');
	}
	if (intval($position) > 9 || intval($position) < 1) {
		return error('-1', '裁剪位置无效');
	}

	$des = dirname($desfile);
		if (!file_exists($des)) {
		if (!mkdirs($des)) {
			return error('-1', '创建目录失败');
		}
	} elseif (!is_writable($des)) {
		return error('-1', '目录无法写入');
	}
		$org_info = @getimagesize($src);
	if ($org_info) {
		if ($org_info[2] == 1) { 			if (function_exists("imagecreatefromgif")) {
				$img_org = imagecreatefromgif($src);
			}
		} elseif ($org_info[2] == 2) {
			if (function_exists("imagecreatefromjpeg")) {
				$img_org = imagecreatefromjpeg($src);
			}
		} elseif ($org_info[2] == 3) {
			if (function_exists("imagecreatefrompng")) {
				$img_org = imagecreatefrompng($src);
			}
		}
	} else {
		return error('-1', '获取原始图像信息失败');
	}

		if ($width == '0' || $width > $org_info[0]) {
		$width = $org_info[0];
	}
	if ($height == '0' || $height > $org_info[1]) {
		$height = $org_info[1];
	}
		switch ($position) {
		case 0 :
		case 1 :
			$dst_x = 0;
			$dst_y = 0;
			break;
		case 2 :
			$dst_x = ($org_info[0] - $width) / 2;
			$dst_y = 0;
			break;
		case 3 :
			$dst_x = $org_info[0] - $width;
			$dst_y = 0;
			break;
		case 4 :
			$dst_x = 0;
			$dst_y = ($org_info[1] - $height) / 2;
			break;
		case 5 :
			$dst_x = ($org_info[0] - $width) / 2;
			$dst_y = ($org_info[1] - $height) / 2;
			break;
		case 6 :
			$dst_x = $org_info[0] - $width;
			$dst_y = ($org_info[1] - $height) / 2;
			break;
		case 7 :
			$dst_x = 0;
			$dst_y = $org_info[1] - $height;
			break;
		case 8 :
			$dst_x = ($org_info[0] - $width) / 2;
			$dst_y = $org_info[1] - $height;
			break;
		case 9 :
			$dst_x = $org_info[0] - $width;
			$dst_y = $org_info[1] - $height;
			break;
		default:
			$dst_x = 0;
			$dst_y = 0;
	}
	if ($width == $org_info[0]) {
		$dst_x = 0;
	}
	if ($height == $org_info[1]) {
		$dst_y = 0;
	}

	if (function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$img_dst = imagecreatetruecolor($width, $height)) {
		imagecopyresampled($img_dst, $img_org, 0, 0, $dst_x, $dst_y, $width, $height, $width, $height);
	} else {
		return error('-1', 'PHP环境不支持图片处理');
	}
	if (function_exists('imagejpeg')) {
		imagejpeg($img_dst, $desfile);
	} elseif (function_exists('imagepng')) {
		imagepng($img_dst, $desfile);
	}
	imagedestroy($img_dst);
	imagedestroy($img_org);
	return true;
}

/**
 * [file_lists 获取文件列表]
 * @param  string  $filepath    [description]
 * @param  integer $subdir      [是否搜索子目录]
 * @param  string  $ex          [搜索扩展名称]
 * @param  integer $isdir       [是否只搜索目录]
 * @param  integer $md5         [是否生成MD5验证码]
 * @param  integer $enforcement [是否开启强制模式]
 * @return [type]               [扫描指定目录中的文件，如果参数 $ext
 *                               不为空，则返回对应的文件类型，最后返回由文件名组成的数组]
 */
function file_lists($filepath, $subdir = 1, $ex = '', $isdir = 0, $md5 = 0, $enforcement = 0) {
	static $file_list = array();
	if ($enforcement) $file_list = array();
	$flags = $isdir ? GLOB_ONLYDIR : 0;
	$list = glob($filepath . '*' . (!empty($ex) && empty($subdir) ? '.' . $ex : ''), $flags);
	if (!empty($ex)) $ex_num = strlen($ex);
	foreach ($list as $k => $v) {
		$v = str_replace('\\', '/', $v);
		$v1 = str_replace(IA_ROOT . '/', '', $v);
		if ($subdir && is_dir($v)) {
			file_lists($v . '/', $subdir, $ex, $isdir, $md5);
			continue;
		}
		if (!empty($ex) && strtolower(substr($v, -$ex_num, $ex_num)) == $ex) {

			if ($md5) {
				$file_list[$v1] = md5_file($v);
			} else {
				$file_list[] = $v1;
			}
			continue;
		} elseif (!empty($ex) && strtolower(substr($v, -$ex_num, $ex_num)) != $ex) {
			unset($list[$k]);
			continue;
		}
	}
	return $file_list;
}


function file_fetch($url, $limit = 0, $path = '') {
	global $_W;
	$url = trim($url);
	if(empty($url)) {
		return error(-1, '文件地址不存在');
	}
	if(!$limit) {
		$limit = $_W['setting']['upload']['image']['limit'] * 1024;
	} else {
		$limit = $limit * 1024;
	}
	if(empty($path)) {
		$path =  "images/{$_W['uniacid']}/" . date('Y/m/');
	}
	if(!file_exists(ATTACHMENT_ROOT . $path)) {
		mkdirs(ATTACHMENT_ROOT . $path);
	}
	load()->func('communication');
	$resp = ihttp_get($url);
	if (is_error($resp)) {
		return error(-1, '提取文件失败, 错误信息: '.$resp['message']);
	}
	if (intval($resp['code']) != 200) {
		return error(-1, '提取文件失败: 未找到该资源文件.');
	}
	$ext = '';
	switch ($resp['headers']['Content-Type']){
		case 'application/x-jpg':
		case 'image/jpeg':
			$ext = 'jpg';
			break;
		case 'image/png':
			$ext = 'png';
			break;
		case 'image/gif':
			$ext = 'gif';
			break;
		default:
			return error(-1, '提取资源失败, 资源文件类型错误.');
			break;
	}
	
	if (intval($resp['headers']['Content-Length']) > $limit) {
		return error(-1, '上传的媒体文件过大('.sizecount($resp['headers']['Content-Length']).' > '.sizecount($limit));
	}
	$filename = file_random_name(ATTACHMENT_ROOT . $path, $ext);
	$pathname = $path . $filename;
	$fullname = ATTACHMENT_ROOT . $pathname;
	if (file_put_contents($fullname, $resp['content']) == false) {
		return error(-1, '提取失败.');
	}
	return $pathname;
}

function file_is_image($url) {
	$pathinfo = pathinfo($url);
	$extension = strtolower($pathinfo['extension']);
	return !empty($extension) && in_array($extension, array('jpg', 'jpeg', 'gif', 'png'));
}
