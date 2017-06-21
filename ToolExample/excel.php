<?php 
// require_once 'PHPExcel.php';       
// require_once 'PHPExcel/Writer/Excel5.php';    
// require_once("..\include\mysqlconn.php"); 
require_once("../vendor/autoload.php");  
//$sdate='2009-01-01';   
//$edate='2009-04-01';   
$cancel_time=date("YmdHis");   
  
$data=new Mysqli();   
$data->connect('60.191.46.50','baixiaoxiao','bxx@DJ2016');  
$data->select_db('db_djkj');  

$sql="select * from sms_record_refund";   
      
// 创建一个处理对象实例       
$objExcel = new PHPExcel();       
      
// 创建文件格式写入对象实例, uncomment       
$objWriter = new PHPExcel_Writer_Excel5($objExcel);  
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');    
    
//设置文档基本属性       
$objProps = $objExcel->getProperties();       				//获得文件属性对象，给下文提供设置资源
$objProps->setCreator("章贡区医疗保险局");       				//设置文件的创建者 
$objProps->setLastModifiedBy("章贡区医疗保险局");       		//设置最后修改者
$objProps->setTitle("章贡区医疗保险局职工月增减变动报表");     //设置标题
$objProps->setSubject("章贡区医疗保险局职工月增减变动报表");   //设置主题   
$objProps->setDescription("章贡区医疗保险局职工月增减变动报表");    //设置备注   
$objProps->setKeywords("章贡区医疗保险局职工月增减变动报表");       //设置标记
$objProps->setCategory("变动报表");       						 //设置类别
      
//*************************************       
//设置当前的sheet索引，用于后续的内容操作。       
//一般只有在使用多个sheet的时候才需要显示调用。       
//缺省情况下，PHPExcel会自动创建第一个sheet被设置SheetIndex=0       
$objExcel->setActiveSheetIndex(0);       
$objActSheet = $objExcel->getActiveSheet();       
      
//设置当前活动sheet的名称       
$objActSheet->setTitle('月增减变动报表');       
      
//*************************************       
//       
//设置宽度，这个值和EXCEL里的不同，不知道是什么单位，略小于EXCEL中的宽度   
$objActSheet->getColumnDimension('A')->setWidth(20);    
$objActSheet->getColumnDimension('B')->setWidth(10);    
$objActSheet->getColumnDimension('C')->setWidth(6);    
$objActSheet->getColumnDimension('D')->setWidth(20);    
$objActSheet->getColumnDimension('E')->setWidth(12);    
$objActSheet->getColumnDimension('F')->setWidth(10);    
$objActSheet->getColumnDimension('G')->setWidth(20);    
$objActSheet->getColumnDimension('H')->setWidth(18);    
$objActSheet->getColumnDimension('I')->setWidth(12);    
$objActSheet->getColumnDimension('J')->setWidth(8);    
$objActSheet->getColumnDimension('K')->setWidth(8);    
$objActSheet->getColumnDimension('L')->setWidth(12);    
$objActSheet->getColumnDimension('M')->setWidth(10);    
$objActSheet->getColumnDimension('N')->setWidth(10);    
  
$objActSheet->getRowDimension(1)->setRowHeight(30);    
$objActSheet->getRowDimension(2)->setRowHeight(27);    
$objActSheet->getRowDimension(3)->setRowHeight(16);    
    
//设置单元格的值     
$objActSheet->setCellValue('A1', '章贡区医疗保险局职工月增减变动报表');    
//合并单元格   
$objActSheet->mergeCells('A1:N1');    
//设置样式   
$objStyleA1 = $objActSheet->getStyle('A1');       
$objStyleA1->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objFontA1 = $objStyleA1->getFont();       
$objFontA1->setName('宋体');       
$objFontA1->setSize(18);     
$objFontA1->setBold(true);       
  
//设置居中对齐   
$objActSheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
  
$objActSheet->setCellValue('A2', '现所在单位');    
$objActSheet->setCellValue('B2', '姓名');    
$objActSheet->setCellValue('C2', '性别');    
$objActSheet->setCellValue('D2', '身份证号码');    
$objActSheet->setCellValue('E2', '参保时间');    
$objActSheet->setCellValue('F2', '增减原因');    
$objActSheet->setCellValue('G2', '原所在单位');    
$objActSheet->setCellValue('H2', '增减时间');    
$objActSheet->setCellValue('I2', '退休时间');    
$objActSheet->setCellValue('J2', '原工资');    
$objActSheet->setCellValue('K2', '现工资');    
$objActSheet->setCellValue('L2', '定点医院');    
$objActSheet->setCellValue('M2', '操作人');    
$objActSheet->setCellValue('N2', '备注');    
  
//设置边框   
$objActSheet->getStyle('A2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('C2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('D2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('E2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('G2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('J2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('K2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('L2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('M2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('N2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
  
$query=$data->query($sql); 
$i=1;   
//从数据库取值循环输出   
while($result=$query->fetch_row()){   
	$personName=$result[1];   
	$idcard=$result[2];   
	$old_company=$result[3];   
	$new_company=$result[4];   
	$sex=$result[5];   
	$start_time=$result[6];   
	$reason=$result[7];   
	$retire_time=$result[8];   
	$old_wages=$result[9];   
	$new_wages=$result[10];   
	$hospital=$result[11];   
	$remarks=$result[12];   
	$operator=$result[13];   
	$oper_time=$result[14];   
  
    $n=$i+2;   
       
    $objActSheet->getStyle('B'.$n)->getNumberFormat()->setFormatCode('@');   
    $objActSheet->getStyle('E'.$n)->getNumberFormat()->setFormatCode('@');   
       
    $objActSheet->getRowDimension($n)->setRowHeight(16);    
       
    $objActSheet->getStyle('A'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('C'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('D'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('E'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('F'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('G'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('H'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('I'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('J'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('K'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('L'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('M'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('N'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
       
    $xb="男";   
    if($sex==1){   
        $xb="女";   
    }   
       
    $objActSheet->setCellValue('A'.$n, $new_company);    
    $objActSheet->setCellValue('B'.$n, $personName);    
    $objActSheet->setCellValue('C'.$n, $xb);    
    $objActSheet->setCellValue('D'.$n, ' '.$idcard.' ');    
    $objActSheet->setCellValue('E'.$n, $start_time);    
    $objActSheet->setCellValue('F'.$n, $reason);    
    $objActSheet->setCellValue('G'.$n, $old_company);    
    $objActSheet->setCellValue('H'.$n, $oper_time);    
    $objActSheet->setCellValue('I'.$n, $retire_time);    
    $objActSheet->setCellValue('J'.$n, $old_wages);    
    $objActSheet->setCellValue('K'.$n, $new_wages);    
    $objActSheet->setCellValue('L'.$n, $hospital);    
    $objActSheet->setCellValue('M'.$n, $operator);    
    $objActSheet->setCellValue('N'.$n, $remarks);    
    $i++;   
}   
  
	// 保存excel
       
	//直接下载
	ob_end_clean();
	ob_start();
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Content-Type:application/force-download');
	header('Content-Type:application/vnd.ms-execl');
	// header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Type:application/octet-stream');
	header('Content-Type:application/download');
	header("Content-Disposition:attachment;filename='采购订单表".date('Ymd').".xls'");
	header('Content-Transfer-Encoding:binary');
	$objWriter->save('php://output');
	//到文件       
	$outputFileName = "./".$cancel_time."addminus.xls";       
	$objWriter->save($outputFileName);
	header("Content-Type: application/force-download"); 
	header("Content-Disposition: attachment; filename=".basename($path)); 



	set_time_limit(0); //设置页面等待时间
	$file_arr = upload_excel();
	$type = $file_arr['excel']['ext'];
	$uploadfile = "./Public/".$file_arr['excel']['savepath'].$file_arr['excel']['savename'];
	if ($uploadfile) {
	    require './ThinkPHP/Library/Vendor/PHPExcel/PHPExcel/IOFactory.php';
	    if($type=='xlsx'||$type=='xls' ){
	        $reader = \PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档
	    }else if( $type=='csv' ){
	        $reader = \PHPExcel_IOFactory::createReader('CSV'); // 读取 csv 文档
	    }else{
	        die('Not supported file types!');
	    }

	    $PHPExcel = $reader->load($uploadfile); // 文档名称
	    $objWorksheet = $PHPExcel->getActiveSheet();
	    // $objWorksheet = $PHPExcel->getSheet(0);
	    $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
	    $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
	    $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
	    //echo $highestRow.$highestColumn;
	    // 一次读取一列
	    $res = array();
	    for ($row = 2; $row <= $highestRow; $row++) {
	        for ($column = 0; $arr[$column] != 'T'; $column++) {
	            $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
	            $res[$row-2][$column] = $val;
	        }
	    }
	}


	    $PHPExcel = $PHPReader->load($filePath);
	    /**读取excel文件中的第一个工作表*/
	    $currentSheet = $PHPExcel->getSheet(0);
	    /**取得最大的列号*/
	    $allColumn = $currentSheet->getHighestColumn();
	    /**取得一共有多少行*/
	    $allRow = $currentSheet->getHighestRow();
	    /**从第二行开始输出，因为excel表中第一行为列名*/
	    for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
		    /**从第A列开始输出*/
		    for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
		        $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
		        if($currentColumn == 'A') {	
		            echo gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($val));

				}else{         
					echo $val; 				
					echo iconv('utf-8','gb2312', $val);
				}
			}
		}