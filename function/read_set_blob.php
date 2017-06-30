<?php 

	// normal hex data

	mysql_connect( "localhost", "root", "password"); //连接数据库   
    mysql_select_db( "database"); //选定数据库   
    //数据插入：  
    $CONTENT="测试内容";   //$CONTENT为新闻内容  
    $COMPRESS_CONTENT = bin2hex(gzcompress($CONTENT));    
    $result=mysql_query( "insert into news (content) value ('$COMPRESS_CONTENT')");//数据插入到数据库news表中  
      
    //展示：  
    $query = "select data from testtable where filename=$filename";   
    $result = mysql_query($query);  
    $COMPRESS_CONTENT=@gzuncompress($result["COMPRESS_CONTENT"]);  
    echo $COMPRESS_CONTENT; 

    //  image hex data 

    mysql_connect( "localhost", "root", "password"); //连接数据库   
    mysql_select_db( "database"); //选定数据库   
       //存储：  
    $filename="" //这里填入图片路径   
    $COMPRESS_CONTENT = addslashes(fread(fopen($filename, "r"), filesize($filename)));//打开文件并规范化数据存入变量$data中  
    $result=mysql_query( "insert into news (content) value ('$COMPRESS_CONTENT')");//数据插入到数据库test表中  
      
    //展示：  
    ob_end_clean();  
    Header( "Content-type: image/gif");  
    $query = "select data from testtable where filename=$filename";   
    $result = mysql_query($query);  
    echo $result["COMPRESS_CONTENT"]; 