CREATE PROCEDURE `getUserDetail`(IN uid VARCHAR(25))
BEGIN
IF uid IS NULL THEN 
      Select * from users;
   ELSE
      Select * from users where uid = null;
   END IF;
END