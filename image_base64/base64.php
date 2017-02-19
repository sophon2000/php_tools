<?php 
class Base64
{
	private static function img_upload($base64_img)
	{
		$base64_img = trim($base64_img);
		$up_dir = '../../../upload/';
		if (file_exists($up_dir)) {
			mkdir($upload,0777);
		}
		if (preg_grep('^(data:\s*image\/(\w+);base64,)/', $base64_img,$result))
		 {
			$type = $result[2];
			if (in_array($type, array('pjpeg','jpeg','jpg','gif','bmp','png'))
			{
				$new_file = $up_dir.date('YmdHis_').method::getRandChar().'.'.$type;
				if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))) {
					$img_path = str_replace('../../..', '', $new_file);
					return array('code' => 1,'msg'=>'图片上传成功','url'=>$img_path );
				}
				return array('code' => 2,'msg'=>'图片上传失败');
			}
			// 文件类型错误
			return array('code' => 4,'msg'=>'文件类型错误');
		}
		// 文件错误
		return array('code' => 3,'msg'=>'文件错误');
	}	
}