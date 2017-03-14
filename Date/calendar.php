<?php
/**
 * [rili 日历]
 * @param  [type] $style [description]
 * @param  [type] $Atime [description]
 * @return [type]        [description]
 */
function rili($style,$Atime){

$debug = false;

$glmonth = date("n",$Atime);    //1-12 
$glday   = date("j",$Atime);    //1-31 
$glweek  = date("w",$Atime);    //0-6 
$glyear  = date("Y",$Atime);    // 
if( $glweek==0 || $glweek==6 ){ 
    $bgcolor="#ff5555"; 
    $fontcolor="yellow"; 
}else{ 
    $bgcolor="#66ccff"; 
    $fontcolor="black"; 
}

$chday=explode(" ","星期日 星期一 星期二 星期三 星期四 星期五 星期六"); 
$chnum=explode(" ","一 二 三 四 五 六 七 八 九 十"); 
//$isBig=explode(" ","大 小"); 
$dayName = explode(" ","初一 初二 初三 初四 初五 初六 初七 初八 初九 初十 十一 十二 十三 十四 十五 十六 十七 十八 十九 二十 廿一 廿二 廿三 廿四 廿五 廿六 廿七 廿八 廿九 三十");

$date = mktime(0,0,0,2,5,2000);  //从庚辰年春节算起   
$K = floor(($Atime - date("U",$date) )/86400 ); 
// 
//$daypyear = array(354,384,354,355,384,355); 
$skydry = explode(" ","甲 乙 丙 丁 戊 已 庚 辛 壬 癸"); 
$groundbranch = explode(" ","子 丑 寅 卯 辰 巳 午 未 申 酉 戌 亥"); 
$nongmonth = explode(" ","正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月"); 
for($i=0;$i < 60;$i++) 
{ 
    $yearName[] = $skydry[($i + 6 )%10].$groundbranch[($i + 4)%12]."年"; 
} 
//$yearName = explode(" ","庚辰年 辛巳年 壬午年 癸未年 甲申年 乙酉年 丙戌年 丁亥年"); 
$adaypmonth = array( 
explode(" ","30 30 29 29 30 29 29 30 29 30 30 29"  ),    //庚辰年 00 
explode(" ","30 30 29 30 -29 30 29 29 30 29 30 29 30"    ),    //辛巳年 01 
explode(" ","30 30 29 30 29 30 29 29 30 29 30 29"  ),    //壬午年 02 
explode(" ","30 30 29 30 30 29 30 29 29 30 29 30"  ),    //癸未年 03 
explode(" ","29 30 -29 30 30 29 30 29 30 29 30 29 30"    ),    //甲申年 04 
explode(" ","29 30 29 30 29 30 30 29 30 29 30 29"  ),    //乙酉年 05 
explode(" ","30 29 30 29 30 29 30 29 -30 30 29 30 30"    ),    //丙戌年 06 
explode(" ","29 29 30 29 29 30 29 30 30 30 29 30"  ),    //丁亥年 07 
explode(" ","30 29 29 30 29 29 30 29 30 30 29 30"  )    //戊子年 08 
); 
if($debug)print_r($adaypmonth); 
while(list($i,$j) = each($adaypmonth)) 
{ 
    //$daypyear[$i] = array_sum($j); 
    $p=0; 
    while(list($m,$n) = each($j)) 
    { 
  if($n>0) 
  { 
      $amname[$i][$m] = $nongmonth[$p]; 
      $p++; 
      $daypyear[$i] += $n; 
  }else 
  { 
      $amname[$i][$m] = "闰".$nongmonth[$p]; 
      $daypyear[$i] -= $n;   
  } 
  if($n == 29 || $n == -29) 
  { 
      $amname[$i][$m] = $amname[$i][$m]."小"; 
  }else 
  { 
      $amname[$i][$m] = $amname[$i][$m]."大"; 
  } 
    } 
} 
/* 
$amname = array( 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //00 
"正月 二月 三月 四月 闰四月 五月 六月 七月 八月 九月 十月 十一月 腊月",  //01 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //02 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //03 
"正月 二月 闰二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",  //04 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //05 
"正月 二月 三月 四月 五月 六月 七月 八月 闰八月 九月 十月 十一月 腊月",  //06 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //07 
"正月 二月 三月 四月 五月 六月 七月 八月 九月 十月 十一月 腊月",      //08 
); 
*/ 
// 
$yearnum = 0; 
while($K >= $daypyear[$yearnum]){ 
//    echo "K=$K yearnum=$yearnum daypyear=${daypyear[$yearnum]}\n"; 
    $K-=$daypyear[$yearnum++]; 
} 
if($debug)echo "K:".$K; 
$year = $yearName[$yearnum]; 
$month = $adaypmonth[$yearnum]; 
//$mName = explode(" ",$amname[$yearnum]); 
$mName = $amname[$yearnum];

$i=0; 
while($K >= $month[$i])$K -= abs($month[$i++]);

/* 
if($month[$i]==29)$l=$isBig[1]; 
else    $l=$isBig[0];    //大小月 
*/ 
//  year  农历的年份 
//  i,nlmonth  农历的月数  数组序号0-12(11)   
//  K,nlday    农历的天数  0-29(28) 
$nlmonth = $i; 
$nlday   = $K+1;$JR1 = ""; //公历节日 

//固定节日 
$gljr = array( 
101=>"元旦", 
202=>"世界湿地日(1996)", 
214=>"情人节", 
303=>"全国爱耳日", 
308=>"妇女节(1910)", 
312=>"植树节(1979)", 
315=>"国际消费者权益日", 
320=>"世界睡眠日", 
325=>"世界气象日", 
401=>"愚人节", 
407=>"世界卫生日", 
501=>"国际劳动节", 
504=>"中国青年节", 
508=>"世界红十字日", 
512=>"国际护士节", 
519=>"全国助残日", 
601=>"国际儿童节", 
605=>"世界环境日", 
622=>"中国儿童慈善活动日", 
623=>"国际奥林匹克日", 

707=>"中国人民抗日战争纪念日", 
801=>"中国人民解放军建军(1927)", 
903=>"抗日战争胜利纪念日(1945)", 
908=>"国际扫盲日", 
910=>"教师节", 
916=>"世界臭氧层保护日", 
918=>"九?一八纪念日", 
927=>"世界旅游日", 
929=>"国际聋人节", 
1001=>"中华人民共和国成立", 
1014=>"世界标准日", 
1024=>"联合国日", 
1205=>"国际志愿人员日", 
1229=>"12.9运动纪念日", 
1225=>"圣诞节" 
);

if(isset($gljr[$glmonth*100+$glday])) $JR1.2881064151=$gljr[$glmonth*100+$glday];

//不固定节日 
//及 
$JR=""; 
switch($glmonth){ 
    case 1: 
  switch($glday){ 
      case 1: 
    $bgcolor="#ff5555";    //元旦 
    $fontcolor="yellow"; 
    break;      
  } 
  break; 
    case 5: 
  switch($glday){ 
      case 1: 
    $bgcolor="#ff5555";    //五一 
    $fontcolor="yellow"; 
    break;      
  } 
  if(($glday>7)&&($glday<15)&&($glweek==0))$JR.="母亲节"; 
  break; 
    case 6: 
  if(($glday>14)&&($glday<22)&&($glweek==0))$JR.="父亲节"; 
  break; 
    case 9: 
  switch($glday){ 
      case 18: 
    $bgcolor="#666666";    //9.18 
    $fontcolor="#ffffff"; 
    break;      
  } 
  break; 
    case 10: 
  switch(date("j",$Atime)){ 
      case 1: 
    $bgcolor="#ff5555";    //国庆 
    $fontcolor="yellow"; 
    $JR.=(date("Y",$Atime)-1949)."周年";break;      
  } 
  break; 
} 
if(strlen($JR)>1)$JR2=$JR;

$JR=""; 
$JR3=""; 
//固定农历节日 
//*********农历节日 
//K为日减一 
switch(substr($mName[$i],0,-2)){ 
    case "正月": 
  switch($nlday){ 
      case 1: 
    $bgcolor="#ff5555";    // 
    $fontcolor="yellow"; 
    $JR3.="春节";break;      
      case 15: 
    $JR3.="元宵节";break;      
  } 
  break; 
    case "二月": 
  switch($nlday){ 
      case 2: 
    $JR3.="龙抬头";break;      
  } 
  break; 
    case "三月": 
  break; 
    case "四月": 
  break; 
    case "五月": 
  switch($nlday){ 
      case 5: 
    $JR3.="端午节";break;      
  } 
  break; 
    case "六月": 
  break; 
    case "七月": 
  switch($nlday){ 
      case 7: 
    $JR3.="七夕";break;      
  } 
  break; 
    case "八月": 
  switch($nlday){ 
      case 15: 
    $bgcolor="#ff5555";    // 
    $fontcolor="yellow"; 
    $JR3.="中秋节";break;      
  } 
  break; 
    case "九月": 
  switch($nlday){ 
      case 9: 
    $JR3.="重阳节";break;      
  } 
  break; 
    case "十月": 
  break; 
    case "十一月": 
  break; 
    case "腊月": 
  switch($nlday){ 
      case 8: 
    $JR3.="腊八";break;      
      case 25: 
    $JR3.="小年";break;      
  } 
  if(($nlday==30)||(($nlday==29)&&(substr($mName[$i],-2)==="小"))){ 
      $bgcolor="#ff5555";    // 
      $fontcolor="yellow"; 
      $JR3.="除夕"; 
  } 
  break; 
}

//24节气 
$nl24j[2002] = array( 
105=>"小寒", 
120=>"大寒", 
204=>"立春", 
219=>"雨水", 
306=>"惊蛰", 
321=>"春分", 
405=>"清明", 
420=>"谷雨", 
506=>"立夏", 
521=>"小满", 
606=>"芒种", 
621=>"夏至", 
707=>"小暑", 
723=>"大暑", 
808=>"立秋", 
823=>"处暑", 
908=>"白露", 
923=>"秋分", 
1008=>"寒露", 
1023=>"霜降", 
1107=>"立冬", 
1122=>"小雪", 
1207=>"大雪", 
1222=>"冬至" 
); 
$nl24j[2003] = array( 
106=>"小寒", 
120=>"大寒", 
204=>"立春", 
219=>"雨水", 
306=>"惊蛰", 
321=>"春分", 
405=>"清明", 
420=>"谷雨", 
506=>"立夏", 
521=>"小满", 
606=>"芒种", 
622=>"夏至", 
707=>"小暑", 
723=>"大暑", 
808=>"立秋", 
823=>"处暑", 
908=>"白露", 
923=>"秋分", 
1009=>"寒露", 
1024=>"霜降", 
1108=>"立冬", 
1123=>"小雪", 
1207=>"大雪", 
1222=>"冬至" 
); 
$nl24j[2004] = array( 
106=>"小寒", 
121=>"大寒", 
204=>"立春", 
219=>"雨水", 
305=>"惊蛰", 
320=>"春分", 
402=>"清明", 
420=>"谷雨", 
505=>"立夏", 
521=>"小满", 
605=>"芒种", 
621=>"夏至", 
707=>"小暑", 
722=>"大暑", 
807=>"立秋", 
823=>"处暑", 
907=>"白露", 
923=>"秋分", 
1008=>"寒露", 
1023=>"霜降", 
1107=>"立冬", 
1122=>"小雪", 
1207=>"大雪", 
1221=>"冬至" 
); 
if(isset($gl24j[$glyear][$glmonth*100+$glday])) $JR4.=$gl24j[$glyear][$glmonth*100+$glday];

if($style=="1"){ 288064151
$str = "<nobr>".date("Y年n月j日",$Atime).$chday[date("w",$Atime)]."</nobr><BR>"; 
$str .="<nobr>农历".$year."".$mName[$i]."".$dayName[$K]."</nobr>"; 
if(strlen("$JR1 $JR2 $JR3 $JR4")>3)$str .="<BR>$JR1 $JR2 $JR3 $JR4"; 
}else{ 
$str = "".date("Y年",$Atime)."<br>".date("n月j日",$Atime)."<br>".$chday[date("w",$Atime)]."<BR>"; 
$str .="农历".$year."<br>".$mName[$i]."".$dayName[$K]; 
if(strlen($JR1)>1)$str.="<BR>$JR1"; 
if(strlen($JR2)>1)$str.="<BR>$JR2"; 
if(strlen($JR3)>1)$str.="<BR>$JR3"; 
if(strlen($JR4)>1)$str.="<BR>$JR4"; 
}

//***************************/ 
echo "<table border=0><tr><td align='center' valign='center'"; 
echo ' bgcolor="'; 
echo $bgcolor.'"'; 
echo "><font style='font-size:9pt;line-height: 150%' color=$fontcolor>$str $JR"; 
echo "</font></td></tr></table>";

}  //end function rili 
?>