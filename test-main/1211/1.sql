-- WHERE Clause
SELECT * FROM `titles` WHERE `Copyright` > 2004
SELECT * FROM `titles` WHERE `EditionNumber` > 4 AND `Copyright` > 2004
SELECT * FROM `authors` WHERE `LastName` LIKE '_o%'


-- ORDER BY Clause
-- ASC: 升序, DESC: 降序
SELECT * FROM `titles` ORDER BY `ISBN` ASC   

SELECT * FROM `titles` ORDER BY `Copyright` DESC, `ISBN` ASC

-- GROUP BY Clause
SELECT `Copyright`,count(*) FROM `titles` GROUP BY `Copyright`

-- Merging Data from Multiple Tables: INNER JOIN
SELECT `FirstName`, `LastName`, `ISBN` FROM `authors` INNER JOIN `authorisbn` ON `authors`.`AuthorID` = `authorISBN`.`AuthorID` ORDER BY `LastName`, `FirstName`

-- INSERT Statement 
INSERT INTO `authors` ( `FirstName`, `LastName` ) VALUES ( 'Sue', 'Red' )

-- UPDATE Statement 
UPDATE `books`.`authors` SET `LastName` = 'Black' WHERE `authors`.`AuthorID` = 5

-- DELETE Statement 
DELETE FROM `authors` WHERE `AuthorID` =5

-- Create Database
CREATE DATABASE DBNAME

-- Create Table
CREATE TABLE Authors
(
   AuthorID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
   FirstName varchar(30) NOT NULL,
   LastName varchar(30) NOT NULL
) 

-- 中文； utf8mb4_general_ci, utf8_unicode_ci