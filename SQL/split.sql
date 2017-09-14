DELIMITER $$
CREATE DEFINER=`root`@`%` FUNCTION `func_get_split_string_total`(
f_string varchar(1000),f_delimiter varchar(5)
) RETURNS int(11)
BEGIN
  return 1+(length(f_string) - length(replace(f_string,f_delimiter,'')));
END$$
DELIMITER ;

ELIMITER $$
CREATE DEFINER=`root`@`%` FUNCTION `func_get_split_string`(
f_string varchar(1000),f_delimiter varchar(5),f_order int) RETURNS varchar(255) CHARSET utf8
BEGIN
  declare result varchar(255) default '';
  set result = reverse(substring_index(reverse(substring_index(f_string,f_delimiter,f_order)),f_delimiter,1));
  return result;
END$$
DELIMITER 

SET @i='1,2,3,4';
SELECT func_get_split_string_total(@i,',');
SELECT func_get_split_string_total(@i,',',2);


SHOW FUNCTION STATUS;
DROP FUNCTION func_get_split_string_total;