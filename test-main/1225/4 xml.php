<?php
$aq = $_POST["aq"];
$aq = strtolower($aq);
header("Access-Control-Allow-Origin: *");
$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = "https://data.moenv.gov.tw/api/v2/aqx_p_432?api_key=e8dd42e6-9b8b-43f8-991e-b3dee723a52d&limit=1000&format=XML" ;
$xml = file_get_contents($url, false, $context);
$xml = simplexml_load_string($xml);
$time = $xml->data->publishtime;
print ("<p>Update Time: $time ; 空汙指標:$aq</p>");
print ("<table><tr><td>測站</td><td>測值</td></tr>");
foreach ($xml->data as $key)
{
    $station = $key->sitename;
    $value = $key->{$aq};
    print ("<tr><td>$station</td><td>$value</td></tr>");
}
print ("</table>");
?>
