<?php
/**
 * 整理的时间类
 */
class time{
    private $year;//年
    private $month;//月
    private $day;//天
    private $hour;//小时
    private $minute;//分钟
    private $second;//秒
    private $microtime;//毫秒
    private $weekday;//星期
    private $longDate;//完整的时间格式
    private $diffTime;//两个时间的差值

    //返回年份 time：时间格式为时间戳  2013-3-27
    function getyear($time="",$type=""){
        if($time==""){
            $time=time();
        }
        if($type==1){
            return $this->year=date("y",$time); //返回两位的年份 13
        }else{
            return $this->year=date("Y",$time); //返回四位的年份 2013
        }
    }
    //返回当前时间的月份 time：时间格式为时间戳 2013-3-27
    function getmonth($time="",$type=""){
        if($time==""){
            $time=time();
        }
        switch($type){
            case 1:$this->month=date("n",$time);//返回格式 3
            break;
            case 2:$this->month=date("m",$time);//返回格式 03
            break;
            case 3:$this->month=date("M",$time);//返回格式 Mar
            break;
            case 4:$this->month=date("F",$time);//返回格式 March
            break;
            default:$this->month=date("n",$time);
        }
        return $this->month; 
    }

    //返回当前时间的天数 time：时间格式为时间戳 2013-3-4 
    function getday($time="",$type=""){
        if($time==""){
            $time=time();
        }
        if($type==1){
            $this->day=date("d",$time);//返回格式 04
        }else{
            $this->day=date("j",$time);//返回格式 4
        }
        return $this->day;
    }
    //返回当前时间的小时  2010-11-10 1:19:21 20:19:21 
    function gethour($time="",$type=""){
        if($time==""){
            $time=time();
        } 
        switch($type){
            case 1:$this->hour=date("H",$time);//格式： 1 20
            break;
            case 2:$this->hour=date("h",$time);//格式  01 08
            break;
            case 3:$this->hour=date("G",$time);//格式  1 20
            break;
            case 4:$this->hour=date("g",$time);//格式  1 8
            break; 
            default :$this->hour=date("H",$time);
        }
        return $this->hour;
    }
    //返回当前时间的分钟数 1:9:18  
    function getminute($time="",$type=""){
        if($time==""){
            $time=time();
        }
        $this->minute=date("i",$time); //格式  09
        return $this->minute;
    }
    //返回当前时间的秒数  20:19:01
    function getsecond($time="",$type=""){
        if($time==""){
            $time=time();
        }
        $this->second=date("s",$time); //格式  01
        return $this->second;
    }
    //返回当前时间的星期数 
    function getweekday($time="",$type=""){
        if($time==""){
            $time=time(); 
        }
        if($type==1){
            $this->weekday=date("D",$time);//格式  Sun
        }else if($type==2){
            $this->weekday=date("l",$time); //格式 Sunday
        }else{
            $this->weekday=date("w",$time);//格式 数字表示 0--6
        }
        return $this->weekday;
    }
    //比较两个时间的大小 格式 2013-3-4 8:4:3  
    function compare($time1,$time2){
        $time1=strtotime($time1);
        $time2=strtotime($time2);
        if($time1>=$time2){  //第一个时间大于等于第二个时间 返回1 否则返回0
            return 1;
        }else{
            return -1;
        }
    }
    //比较两个时间的差值
    function diffdate($time1="",$time2=""){
        //echo $time1.'------'.$time2.'<br>';
        if($time1==""){
            $time1=date("Y-m-d H:i:s"); 
        }
        if($time2==""){ 
            $time2=date("Y-m-d H:i:s"); 
        }
        $date1=strtotime($time1);
        $date2=strtotime($time2);
        if($date1>$date2){
            $diff=$date1-$date2; 
        }else{
            $diff=$date2-$date1;
        }
        if($diff>=0){
            $day=floor($diff/86400);
            $hour=floor(($diff%86400)/3600);
            $minute=floor(($diff%3600)/60);
            $second=floor(($diff%60));
            $this->diffTime='相差'.$day.'天'.$hour.'小时'.$minute.'分钟'.$second.'秒';
        }
        return $this->diffTime;
    }
    //返回 X年X月X日
    function buildDate($time="",$type=""){
        if($type==1){   
            $this->longDate = $this->getyear($time) . '年' . $this->getmonth($time) . '月' . $this->getday($time) . '日';  
        }else{
            $this->longDate = $this->getyear($time) . '年' . $this->getmonth($time) . '月' . $this->getday($time) . '日'.$this->gethour($time).':'.$this->getminute($time).':'.$this->getsecond($time);  
        }
        return $this->longDate;  
    }
}
