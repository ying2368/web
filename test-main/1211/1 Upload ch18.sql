/*  1. Merge table (Summary, Dist_info, Type_info)  */
SELECT * FROM `dist_info` 
INNER JOIN `summary` ON `dist_info`.`DistrictID` = `summary`.`DistrictID` 
INNER JOIN `type_info` ON `summary`.`TYPEID` = `type_info`.`TYPEID`

/*  2. 列出所有中壢區房子的交易價  */
SELECT * FROM `dist_info` 
INNER JOIN `summary` ON `dist_info`.`DistrictID` = `summary`.`DistrictID` 
INNER JOIN `type_info` ON `summary`.`TYPEID` = `type_info`.`TYPEID`
WHERE `dist_info`.`DistrictID` = 3 AND `type_info`.`TYPEID` = 'A'

/*  3. 計算各區房子的平均交易價  */
SELECT `dist_info`.`Name`, avg(`summary`.`Price`) FROM `dist_info` 
INNER JOIN `summary` ON `dist_info`.`DistrictID` = `summary`.`DistrictID` 
INNER JOIN `type_info` ON `summary`.`TYPEID` = `type_info`.`TYPEID`
WHERE `type_info`.`TYPEID` = 'A'
Group by `dist_info`.`Name`