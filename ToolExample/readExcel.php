<?php 

require_once("../vendor/autoload.php");  

$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',')
                                                    ->setEnclosure('"')
                                                    ->setLineEnding("\r\n")
                                                    ->setSheetIndex(0);
$objPHPExcelFromCSV = $objReader->load($path);
$objWorksheet = $objPHPExcelFromCSV->getActiveSheet();
$highestRow = $objWorksheet->getHighestRow(); // 取得总行数
$highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
$arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
// 一次读取一列
$res = array();

for ($row = 4; $row <= $highestRow; $row++) {
    for ($column = 1; $arr[$column] != 'L'; $column++) {
        // $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
        // $res[$row-2][$column] = $val;
        if ($column == 2 ) {
        	$val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
        	$res[$row-4]['trade_no'] = $this->NumToStr($val);
        }
        if ($column == 4 ) {
        	$val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
        	$res[$row-4]['note'] = $val;
        }
        if ($column == 6) {
        	$val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
        	if ($val == "SUCCESS") {
        		$res[$row-4]['trad_stat'] = 31;
        	}else{
        		$res[$row-4]['trad_stat'] = false;
        		// unset($res[$row-4]);
        	}
        }
    }
}