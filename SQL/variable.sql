--C语言中变量未赋值时是不确定值，T-SQL中变量未赋值时是NULL
DECLARE @i int, @s varchar(100), @d datetime
SELECT @i, @s, @d
GO
--严谨起见，使用变量时最好赋初值，特别是依赖与变量初值的逻辑
DECLARE @i int, @s varchar(100)
SET @s = NULL --这句可省略，但假如未来版本中变量未赋值时不再是NULL，代码会出错。
SET @i = 0
WHILE @i < 5
BEGIN
    SET @s = ISNULL(@s + ',', '') + CAST(@i AS varchar(10))
    SET @i = @i + 1
END
SELECT @s
GO
 
--根据查询为变量赋值
CREATE TABLE #Nums(
    n int NOT NULL PRIMARY KEY CLUSTERED,
    n2 AS n * n,
    s AS CAST(n AS varchar(10)) + '^2 = ' + CAST(n * n AS varchar(10))
)
INSERT INTO #Nums(n)
SELECT TOP(10) n = ROW_NUMBER() OVER(ORDER BY (SELECT 1))
FROM sys.columns
GO
--方法1：SET 变量 = 标量值（或标量子查询）
DECLARE @i1 int, @i2 int
SET @i1 = (SELECT n FROM #Nums WHERE n = 1)
SET @i2 = (SELECT MAX(n2) FROM #Nums)
SELECT @i1, @i2
GO
--方法2：SELECT 变量 = 标量值（或列名）[ FROM ...]
DECLARE @i1 int, @i2 int
SELECT @i1 = n FROM #Nums WHERE n = 1
SELECT @i2 = MAX(n2) FROM #Nums
SELECT @i1, @i2
GO
--方法1与方法2的不同
--a. 方法2可以一次为多个变量赋值
DECLARE @i11 int, @i12 int, @i13 int, @i14 int
DECLARE @i21 int, @i22 int, @i23 int, @i24 int
SET @i11 = 3
SET @i12 = 9
SET @i13 = (SELECT n FROM #Nums WHERE n = 3) --查询表两次
SET @i14 = (SELECT n2 FROM #Nums WHERE n = 3)
SELECT @i11, @i12, @i13, @i14
SELECT @i21 = 3, @i22 = 9
SELECT @i23 = n, @i24 = n2 FROM #Nums WHERE n = 3 --查询表一次
SELECT @i21, @i22, @i23, @i24
GO
--b. 当查询返回多行结果时，方法1是报错，方法2是多次赋值（保持最后一个值）
DECLARE @i1 int
SET @i1 = (SELECT n FROM #Nums) --报错
GO
DECLARE @i2 int
SELECT @i2 = n FROM #Nums --多次赋值并保持最后一个值
SELECT @i2
/*
所谓“最后一个值”依赖于查询返回结果集的顺序。
在不指定ORDER BY的情况下，查询返回顺序依赖于表中数据的物理存储顺序和具体的执行计划，顺序是不确定的。
*/
GO
--c. 当查询返回空结果集（不是NULL）时，方法1是把空结果集转换为NULL（标量）再赋值，方法2是不进行赋值操作
DECLARE @i1 int, @i2 int
SET @i1 = 11111 --初始值
SET @i2 = 22222 --初始值
SET @i1 = (SELECT n FROM #Nums WHERE 1 = 0)
SELECT @i2 = n FROM #Nums WHERE 1 = 0
SELECT @i1, @i2
GO
--因为目前SELECT赋值的本质是循环赋值，可以用以下方法拼接值：
DECLARE @s varchar(100)
SET @s = NULL
SELECT @s = ISNULL(@s + ',', '') + CAST(n2 AS varchar(10))
FROM #Nums
ORDER BY n
SELECT @s
--但微软官方不保证这种SELECT赋值机制未来不会改变。
GO
--在SQL Server 2005之后可以用以下方法取代：
DECLARE @s varchar(100)
SET @s = STUFF((SELECT ',' + CAST(n2 AS varchar(10)) FROM #Nums ORDER BY n FOR XML PATH('')),1,1,'')
SELECT @s
GO
 
--T-SQL变量作用域：在当前会话中，从变量声明处到当前批的结束。
--与代码块无关
DECLARE @outer int
SET @outer = 1
BEGIN
    DECLARE @inner int
    SET @inner = 2
    SELECT @outer, @inner
END
SELECT @outer, @inner
--只能通过参数传递到子会话
EXEC sp_executesql N'SELECT @vo, @vi', N'@vo int, @vi int',
    @vo = @outer, @vi = @inner  --调用存储过程和函数也是一样
PRINT '====到此为止是OK的===='
--当前会话的变量作用域不能延伸到子会话
EXEC('SELECT @outer, @inner')   --调用存储过程和函数也是一样
GO
--不能跨批
SELECT @outer, @inner
GO