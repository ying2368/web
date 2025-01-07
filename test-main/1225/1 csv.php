<?php
$aq = $_POST["aq"];
$data = file_get_contents('https://data.moenv.gov.tw/api/v2/aqx_p_432?api_key=e8dd42e6-9b8b-43f8-991e-b3dee723a52d&limit=1000&format=CSV');
$rows = explode("\n",$data);   //根據換行做切割
$s = array();
$num=0;
foreach($rows as $row) {
    $s[] = str_getcsv($row);
    $num++;
}
$time = $s[3][16];
print ("<p>Update Time: $time ; 空汙指標:$aq</p>");
$index =0;
switch ($aq)
{
    case "AQI":$index=2;break;
    case "SO2":$index=5;break;
    case "CO":$index=6;break;
    case "O3":$index=7;break;
    case "PM10":$index=9;break;
    case "PM2.5":$index=10;break;
    case "NO2":$index=11;break;
}
print ("<table><tr><td>測站</td><td>測值</td></tr>");
for ($i=3;$i<$num-1;$i++)
{
    $station = $s[$i][0];
    $value = $s[$i][$index];
    print ("<tr><td>$station</td><td>$value</td></tr>");
}
print ("</table>");
?>
