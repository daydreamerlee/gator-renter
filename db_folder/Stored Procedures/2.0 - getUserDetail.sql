USE `mini`;
DROP procedure IF EXISTS `getUserDetail`;

DELIMITER $$
USE `mini`$$
CREATE PROCEDURE `getUserDetail` (in uid varchar(25))
BEGIN
IF uid IS NULL THEN 
      Select * from users;
   ELSE
      Select * from users where uid = null;
   END IF;
END$$

DELIMITER ;
