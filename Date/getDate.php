<?php 
 
    $time = strtotime("2011-03-31");  
      
    /** 
     * 计算上一个月的今天，如果上个月没有今天，则返回上一个月的最后一天 
     * @param type $time 
     * @return type
     * http://www.jbxue.com
     */       
    function last_month_today($time){  
        $last_month_time = mktime(date("G", $time), date("i", $time),  
                    date("s", $time), date("n", $time), 0, date("Y", $time));  
        $last_month_t =  date("t", $last_month_time);  //二月份的天数  
      
        if ($last_month_t < date("j", $time)) {  
            return date("Y-m-t H:i:s", $last_month_time);  
        }  
      
        return date(date("Y-m", $last_month_time) . "-d", $time);  
    }  
      
    echo last_month_today($time);  
    var_dump(date("H",time()).date("a",time()));  
    var_dump(date("Y-m-d H:i:s ",mktime(0,0,0,4,-31,2011)));  
