<?php
$year = $_POST["year"];
$data = file_get_contents('https://opendata.tycg.gov.tw/api/v1/dataset.api_access?rid=06f878b6-92e3-4b63-9960-1210d12fd27e&format=csv');
$rows = explode("\n",$data);   //根據換行做切割
$s = array();
$num=0;
foreach($rows as $row) {
    $s[] = str_getcsv($row);
    $num++;
}


print ("<table><tr><td>年度</td><td>月份</td><td>單月平均日運量</td></tr>");
for ($i=1;$i<$num-1;$i++)
{
    $y = $s[$i][0];
    $m = $s[$i][1];
    $v = $s[$i][2];

    if($y == $year){
        print ("<tr><td>$y</td><td>$m</td><td>$v</td></tr>\n");
    }
}
print ("</table>");
?>
