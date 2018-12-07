<?php
$bot_api_key="727078481:AAFd56a-Za91ZN7e7V8-1i3FexMThfgstVM";
function send_get_message($url){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_ERL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$result = curl_exec($ch);
	curl_close($ch); 
	return $result;
}


$text = @$_GET["text"];
$tgid = @$_GET["tgid"];
if($text){
	$url="https://api.telegram.org/bot".$bot_api_key."/sendMessage?chat_id=$tgid&text=".$text;
	$get_send_result=send_get_message($url);
	echo $get_send_result;
}
/*
if($text){
 $url = "https://api.telegram.org/bot$bot_api_key/sendMessage?chat_id=$tgid&text=$text";
 echo send_get($url);
}else{
 echo "Please Input";
}
*/
?>