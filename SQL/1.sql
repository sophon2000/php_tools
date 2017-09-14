
--处理表重复记录(查询和删除)
1、Num、Name相同的重复值记录,没有大小关系只保留一条
2、Name相同,ID有大小关系时,保留大或小其中一个记录

--1、用于查询重复处理记录(如果列没有大小关系时2000用生成自增列和临时表处理,SQL2005用row_number函数处理)

if not object_id('Tempdb..#T') is null
    drop table #T
Go
Create table #T([ID] int,[Name] nvarchar(1),[Memo] nvarchar(2))
Insert #T
select 1,N'A',N'A1' union all
select 2,N'A',N'A2' union all
select 3,N'A',N'A3' union all
select 4,N'B',N'B1' union all
select 5,N'B',N'B2'
Go


--I、Name相同ID最小的记录(推荐用1,2,3),方法3在SQl05时，效率高于1、2
方法1:
Select * from #T a where not exists(select 1 from #T where Name=a.Name and ID<a.ID)

方法2:
select a.* from #T a join (select min(ID)ID,Name from #T group by Name) b on a.Name=b.Name and a.ID=b.ID

方法3:
select * from #T a where ID=(select min(ID) from #T where Name=a.Name)

方法4:
select a.* from #T a join #T b on a.Name=b.Name and a.ID>=b.ID group by a.ID,a.Name,a.Memo having count(1)=1 

方法5:
select * from #T a group by ID,Name,Memo having ID=(select min(ID)from #T where Name=a.Name)

方法6:
select * from #T a where (select count(1) from #T where Name=a.Name and ID<a.ID)=0

方法7:
select * from #T a where ID=(select top 1 ID from #T where Name=a.name order by ID)

方法8:
select * from #T a where ID!>all(select ID from #T where Name=a.Name)

方法9(注:ID为唯一时可用):
select * from #T a where ID in(select min(ID) from #T group by Name)

--SQL2005:

方法10:
select ID,Name,Memo from (select *,min(ID)over(partition by Name) as MinID from #T a)T where ID=MinID

方法11:

select ID,Name,Memo from (select *,row_number()over(partition by Name order by ID) as MinID from #T a)T where MinID=1

生成结果:
/*
ID          Name Memo
----------- ---- ----
1           A    A1
4           B    B1

(2 行受影响)
*/


--II、Name相同ID最大的记录,与min相反:
方法1:
Select * from #T a where not exists(select 1 from #T where Name=a.Name and ID>a.ID)

方法2:
select a.* from #T a join (select max(ID)ID,Name from #T group by Name) b on a.Name=b.Name and a.ID=b.ID order by ID

方法3:
select * from #T a where ID=(select max(ID) from #T where Name=a.Name) order by ID

方法4:
select a.* from #T a join #T b on a.Name=b.Name and a.ID<=b.ID group by a.ID,a.Name,a.Memo having count(1)=1 

方法5:
select * from #T a group by ID,Name,Memo having ID=(select max(ID)from #T where Name=a.Name)

方法6:
select * from #T a where (select count(1) from #T where Name=a.Name and ID>a.ID)=0

方法7:
select * from #T a where ID=(select top 1 ID from #T where Name=a.name order by ID desc)

方法8:
select * from #T a where ID!<all(select ID from #T where Name=a.Name)

方法9(注:ID为唯一时可用):
select * from #T a where ID in(select max(ID) from #T group by Name)

--SQL2005:

方法10:
select ID,Name,Memo from (select *,max(ID)over(partition by Name) as MinID from #T a)T where ID=MinID

方法11:
select ID,Name,Memo from (select *,row_number()over(partition by Name order by ID desc) as MinID from #T a)T where MinID=1

生成结果2:
/*
ID          Name Memo
----------- ---- ----
3           A    A3
5           B    B2

(2 行受影响)
*/



--2、删除重复记录有大小关系时,保留大或小其中一个记录


--> --> (Roy)生成測試數據

if not object_id('Tempdb..#T') is null
    drop table #T
Go
Create table #T([ID] int,[Name] nvarchar(1),[Memo] nvarchar(2))
Insert #T
select 1,N'A',N'A1' union all
select 2,N'A',N'A2' union all
select 3,N'A',N'A3' union all
select 4,N'B',N'B1' union all
select 5,N'B',N'B2'
Go

--I、Name相同ID最小的记录(推荐用1,2,3),保留最小一条
方法1:
delete a from #T a where  exists(select 1 from #T where Name=a.Name and ID<a.ID)

方法2:
delete a  from #T a left join (select min(ID)ID,Name from #T group by Name) b on a.Name=b.Name and a.ID=b.ID where b.Id is null

方法3:
delete a from #T a where ID not in (select min(ID) from #T where Name=a.Name)

方法4(注:ID为唯一时可用):
delete a from #T a where ID not in(select min(ID)from #T group by Name)

方法5:
delete a from #T a where (select count(1) from #T where Name=a.Name and ID<a.ID)>0

方法6:
delete a from #T a where ID<>(select top 1 ID from #T where Name=a.name order by ID)

方法7:
delete a from #T a where ID>any(select ID from #T where Name=a.Name)



select * from #T

生成结果:
/*
ID          Name Memo
----------- ---- ----
1           A    A1
4           B    B1

(2 行受影响)
*/


--II、Name相同ID保留最大的一条记录:

方法1:
delete a from #T a where  exists(select 1 from #T where Name=a.Name and ID>a.ID)

方法2:
delete a  from #T a left join (select max(ID)ID,Name from #T group by Name) b on a.Name=b.Name and a.ID=b.ID where b.Id is null

方法3:
delete a from #T a where ID not in (select max(ID) from #T where Name=a.Name)

方法4(注:ID为唯一时可用):
delete a from #T a where ID not in(select max(ID)from #T group by Name)

方法5:
delete a from #T a where (select count(1) from #T where Name=a.Name and ID>a.ID)>0

方法6:
delete a from #T a where ID<>(select top 1 ID from #T where Name=a.name order by ID desc)

方法7:
delete a from #T a where ID<any(select ID from #T where Name=a.Name)


select * from #T
/*
ID          Name Memo
----------- ---- ----
3           A    A3
5           B    B2

(2 行受影响)
*/





--3、删除重复记录没有大小关系时，处理重复值


--> --> (Roy)生成測試數據
 
if not object_id('Tempdb..#T') is null
    drop table #T
Go
Create table #T([Num] int,[Name] nvarchar(1))
Insert #T
select 1,N'A' union all
select 1,N'A' union all
select 1,N'A' union all
select 2,N'B' union all
select 2,N'B'
Go

方法1:
if object_id('Tempdb..#') is not null
    drop table #
Select distinct * into # from #T--排除重复记录结果集生成临时表#

truncate table #T--清空表

insert #T select * from #    --把临时表#插入到表#T中

--查看结果
select * from #T

/*
Num         Name
----------- ----
1           A
2           B

(2 行受影响)
*/

--重新执行测试数据后用方法2
方法2:

alter table #T add ID int identity--新增标识列
go
delete a from  #T a where  exists(select 1 from #T where Num=a.Num and Name=a.Name and ID>a.ID)--只保留一条记录
go
alter table #T drop column ID--删除标识列

--查看结果
select * from #T

/*
Num         Name
----------- ----
1           A
2           B

(2 行受影响)

*/

--重新执行测试数据后用方法3
方法3:
declare Roy_Cursor cursor local for
select count(1)-1,Num,Name from #T group by Num,Name having count(1)>1
declare @con int,@Num int,@Name nvarchar(1)
open Roy_Cursor
fetch next from Roy_Cursor into @con,@Num,@Name
while @@Fetch_status=0
begin 
    set rowcount @con;
    delete #T where Num=@Num and Name=@Name
    set rowcount 0;
    fetch next from Roy_Cursor into @con,@Num,@Name
end
close Roy_Cursor
deallocate Roy_Cursor

--查看结果
select * from #T
/*
Num         Name
----------- ----
1           A
2           B

(2 行受影响)
*/
