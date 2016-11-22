USE `mini`;
DROP procedure IF EXISTS `getUserDetail`;

DELIMITER $$
USE `mini`$$
CREATE PROCEDURE `getUserDetail` (in userid varchar(25))
BEGIN
IF userid IS NULL THEN 
      Select * from users;
   ELSE
      Select * from users where uid = userid and is_active <> 0;
   END IF;
END$$

DELIMITER ;
