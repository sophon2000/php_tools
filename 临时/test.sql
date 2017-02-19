select d.user_name,c.timestr,kills from 
(select user_id,timestr,kills,
	(select count(*) from user_kills b where b.user_id=a.user_id and a.kills<=b.kills) as cnt 
from user_kills a  
group by user_id,timestr,kills) c 
join user1 d on c.user_id=d.id where cnt<=2

select a.`user_name`,a.`over`,b.`over` from `user1` a inner join `user2` b on a.`user_name`=b.`user_name`

select a.user_name,a.over,b.over from user1 a left join user2 b on a.user_name = b.user_name where b.user_name is null
union all
select b.user_name,b.over,a.over from user1 a right join user2 b on a.user_name=b.user_name where a.user_name is null


select a.user_name,b.user_name from user1 a cross join user2 b

UPDATE user1 SET over='大地球' WHERE user1.user_name IN (SELECT b.user_name FROM user1 a INNER JOIN user2 b ON a.user_name=b.user_name)

UPDATE user1 a JOIN (SELECT b.user_name FROM user1 a INNER JOIN user2 b ON a.user_name=b.user_name) b ON a.user_name=b.user_name SET a.over='啊啊啊'

select a.user_name,a.over,(select b.over from user2 b where b.user_name=a.user_name)as over2 from user1 a

select a.user_name,a.over,b.over as over2 from user1 a left join user2 b on a.user_name=b.user_name

select a.user_name,b.timestr,b.kills from user1 a left join kill b on a.id = b.user_id order by b.timestr desc limit 1

select sum(case when user_name='沙僧' then kills end)as `沙僧`,sum(case when user_name='孙悟空' then kills end)as `孙悟空`,sum(case when user_name='猪八戒' then kills end) as `猪八戒` from user1 a join kills b on a.id=b.user_id;

select a.user_name ,sum(kills) from user1 a join kills b on a.id=b.user_id group by a.user_name;

select * from(select sum(kills)as '沙僧' from user1 a join kills b on a.id=b.user_id and a.user_name='沙僧') a
cross join
(select sum(kills)as '猪八戒' from user1 a join kills b on a.id=b.user_id and a.user_name='猪八戒') b
cross join
(select sum(kills)as '孙悟空' from user1 a join kills b on a.id=b.user_id and a.user_name='孙悟空') c;

select user_name concat(mobile,',')as mobile,LENGTH(mobile)-LENGTH(REPLACE(mobile,',',' '))+1 size from user1 b;

select user_name,
REPLACE(substring(substring_index(mobile,',',a.id),char_length(substring_index(mobile,',',a.id-1))+1),',','')
as mobile
from tb_sequence a cross join (
select user_name,CONCAT(mobile,',')as mobile,LENGTH(mobile)-LENGTH(REPLACE(mobile,',',''))+1 size from user1 b
)b on a.id<=b.size;

select user_name,'shoe' as equipment,shoe from user1 a join user1_equipment b on a.id = b.user_id 
union all
select user_name,'clothing' as equipment,clothing from user1 a join user1_equipment b on a.id=b.user_id
union all 
select user_name ,'arms' as equipment,arms from user1 a join user1_equipment b on a.id=b.user_id;

