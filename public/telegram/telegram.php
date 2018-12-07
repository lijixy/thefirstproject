<?php
$bot_api_key="7bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY";
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
//$tgid = @$_GET["tgid"];
if($text){
	//curl  "https://api.telegram.org/bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY/sendMessage?chat_id=613744501&text=李记哥哥"
	$url="https://api.telegram.org/".$bot_api_key."/sendMessage?chat_id=613744501&text=".$text;
	$get_send_result=send_get_message($url);
	echo $get_send_result;
}
/*
if($text){
 $url = "https://api.telegram.org/bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY/sendMessage?chat_id=252300608&text=fdffasd";
 echo send_get($url);
}else{
 echo "Please Input";
}
*/
?>