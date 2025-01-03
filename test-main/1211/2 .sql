
/* INSERT Statement */
INSERT INTO `authors` ( `FirstName`, `LastName` ) VALUES ( 'Sue', 'Red' )

CREATE TABLE Authors
(
   AuthorID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
   FirstName varchar(30) NOT NULL,
   LastName varchar(30) NOT NULL
) 



/* UPDATE Statement */
UPDATE `books`.`authors` SET `LastName` = 'Black' WHERE `authors`.`AuthorID` = 5


/* DELETE Statement */
DELETE FROM `authors` WHERE `AuthorID` =5
