<?php 

	public function back_refund_csv()
	{
		// 数据
		// 1 支付宝 2 微信
		$pay_way    = isset($_POST['pay_way'])? $_POST['pay_way'] : 1;
		$subFile = isset($_FILES['refund_csv'])?$_FILES['refund_csv']:0;
	  	if(empty($subFile))
	  	{
	    	return $this->message('请选择要上传的文件',4);
	  	}
    	if ($subFile['name'])
		{
	 		
	      	$checkData = array(
		        'maxSize' => 10000,
		        'extArr' => array('csv')
		      	);
	      	if ($subFile['size']>$checkData['maxSize'] || !in_array( explode('.', $subFile['name'])[1] ,$checkData['extArr']))
	      	{
	        	return $this->message("请上传正确的文件",3);
	      	}
	      	//移动文件
	      	$filePath = "./upload/退款回单-".date('YmdHis').$subFile['name'];
	      		// echo $subFile['tmp_name'],' ',$filePath;exit;
	      	// if(move_uploaded_file($subFile['tmp_name'], $filePath)){
	      	if($filePath = $subFile['tmp_name']){
	      		$status = $this->model->back_refund_csv($filePath,$pay_way);
	      		if ($status) {
	      			return $this->message("上传成功",1);
	      		}
	      		return $this->message("导入失败,请重试",4);
	      	}else{
	      		return $this->message("上传失败,请重试",4);
	      	}
	      	
    	}else{
	      	return $this->message("文件不能为空",3);
	    }
	}