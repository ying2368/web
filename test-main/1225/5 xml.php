<?php
header("Access-Control-Allow-Origin: *");
$input = $_POST["input"];
$item = preg_replace("/s$/","",$input);  //刪除字尾s

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = "StationFacilityList.xml" ;
$xml = file_get_contents($url, false, $context);
$xml = simplexml_load_string($xml);

print ("<table>");
foreach ($xml->StationFacility as $key)
{
    $ID = $key->StationID;
    $station = $key->StationName->Zh_tw;
    foreach ($key->{$input}->{$item} as $k2)
    {
        $des = $k2->Description;
        print ("<tr><td>$ID</td><td>$station</td><td>$des</td></tr>");
    }
    
}
print ("</table>");
?>
