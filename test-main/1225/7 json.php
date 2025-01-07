<?php
header("Access-Control-Allow-Origin: *");
$dist = $_POST["dist"];
//$dist = "大安區";
$context  = stream_context_create(array('http' => array('header' => 'Accept: application/json')));
$url = "https://tcgbusfs.blob.core.windows.net/blobtcmsv/TCMSV_alldesc.json" ;
$xml = file_get_contents($url, false, $context);
$xml = json_decode($xml);
print ("<p>行政區:$dist</p>");
print ("<table><tr><td>行政區</td><td>停車場名稱</td><td>地址</td></tr>");
foreach ($xml->data->park as $key)
{
	$d = $key->{"area"};
    if (strcmp($d,$dist)==0)
    {
	$station = $key->{"name"};
	$value = $key->{"address"};
	print ("<tr><td>$d</td><td>$station</td><td>$value</td></tr>");
    }
}
print ("</table>");
?>
