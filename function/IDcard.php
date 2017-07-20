<?php 
/驗證身份證
function checkId($id) {
  if (!preg_match('/^([\d]{17}[xX\d])$/', $id)) {
    return FALSE;
  }
  //验证地址码:省
  if (10 > substr($id, 0, 2) || substr($id, 0, 2) > 66) {
    return FALSE;
  }
  //验证出生日期码
  $yearNum  = substr($id, 6, 4);
  $monthNum = substr($id, 10, 2);
  $dayNum   = substr($id, 12, 2);
  $sexNum   = substr($id, 16, 1);
  $endNum   = substr($id, 17, 1);

  $nowY = date("Y", time());

  if (1900 > $yearNum || $yearNum >= $nowY) {
    return FALSE;
  }
  else {
    if ($monthNum > 12 || $monthNum < 1) {
      return FALSE;
    }
    if (in_array($monthNum, [
        '01',
        '03',
        '05',
        '07',
        '08',
        '10',
        '12'
      ]) && ($dayNum > 31 || $dayNum < 1)
    ) {
      return FALSE;
    }
    if (in_array($monthNum, [
        '02',
        '04',
        '06',
        '09',
        '11'
      ]) && ($dayNum > 30 || $dayNum < 1)
    ) {
      return FALSE;
    }
    if (($yearNum % 4 == 0 && $yearNum % 100 != 0) || ($yearNum % 400 == 0)) {
      //闰年
      if ($monthNum == '02' && $dayNum > 29) {
        return FALSE;
      }
    }
    else {
      if ($monthNum == '02' && $dayNum > 28) {
        return FALSE;
      }
    }
  }
  //验证最后一位校验码
  $a = str_split($id, 1);
  $w = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
  $c = array(1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2);
  $sum = 0;
  for ($i = 0; $i < 17; $i++) {
    $sum += $a[$i] * $w[$i];
  }
  $r = $sum % 11;
  $res = $c[$r];
  if ($res != $a[17]) {
    return FALSE;
  }

  return TRUE;
}

//身份证检查年龄
function check_age($id_number){
  if(strlen($id_number)==18){
    $tyear  = intval(substr($id_number,6,4));
    $tmonth = intval(substr($id_number,10,2));
    $tday   = intval(substr($id_number,12,2));
    $time1  = mktime(23,59,59,date('m'),date('d'),date('Y')-16);
    $time2  = mktime(23,59,59,$tmonth,$tday,$tyear);
    if(mktime(23,59,59,$tmonth,$tday,$tyear)>mktime(23,59,59,date('m'),date('d'),date('Y')-16)){
      return FALSE;
    }
  }elseif(strlen($id_number)==15){
    $tyear=intval("19".substr($id_number,6,2));
    $tmonth=intval(substr($id_number,8,2));
    $tday=intval(substr($id_number,10,2));
    if(mktime(23,59,59,$tmonth,$tday,$tyear)>mktime(23,59,59,date('m'),date('d'),date('Y')-16)){
      return FALSE;
    }
  }
  return TRUE;
}
