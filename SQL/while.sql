-- 创建存储过程 学习while循环的用法
create procedure test_while (IN in_count INT) 
BEGIN
    declare count INT default 0;
    while count < 10 do
        set count = count + 1;
    end while;
    select count;
END；
-- 调用存储过程
call test_while(10);
-- 删除存储过程
drop procedure test_while; 