<?php
$bot_api_key = 'CHANGE HERE';
/*
function send_get($urlstring){
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $urlstring);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 $result = curl_exec($ch);
 curl_close($ch); return $result;
}
*/
$text = @$_GET["text"];
$tgid = @$_GET["tgid"];
print($text);
/*
if($text){
 $url = "https://api.telegram.org/bot$bot_api_key/sendMessage?chat_id=$tgid&text=$text";
 echo send_get($url);
}else{
 echo "Please Input";
}
*/
?>