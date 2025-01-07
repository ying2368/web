<?php
header("Access-Control-Allow-Origin: *");
$aq = $_POST["aq"];
$aq = strtolower($aq);
$context  = stream_context_create(array('http' => array('header' => 'Accept: application/json')));
$url = "https://data.moenv.gov.tw/api/v2/aqx_p_432?api_key=e8dd42e6-9b8b-43f8-991e-b3dee723a52d&limit=1000&format=json" ;
$data = file_get_contents($url, false, $context);
$data = json_decode($data);
$time = $data->records[0]->publishtime;
print ("<p>Update Time: $time ; 空汙指標:$aq</p>");
print ("<table><tr><td>測站</td><td>測值</td></tr>");
foreach ($data->records as $key)
{
    $station = $key->{"sitename"};
    $value = $key->{$aq};
    print ("<tr><td>$station</td><td>$value</td></tr>");
}
print ("</table>");
?>
 
