USE `mini`;
DROP procedure IF EXISTS `getUserDetail`;

DELIMITER $$
USE `mini`$$
CREATE PROCEDURE `getUserDetail` (in userid varchar(25))
BEGIN
IF userid IS NULL THEN 
      Select * from users where is_active <> 0;
   ELSE
      Select * from users where uid = userid and is_active <> 0;
   END IF;
END$$

DELIMITER ;
