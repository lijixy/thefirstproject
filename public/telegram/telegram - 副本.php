<?php
$bot_api_key="7bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY";

function getUpdates($offset = 0, $limit = 100, $timeout = 0, $update = true){
	$content = ['offset' => $offset, 'limit' => $limit, 'timeout' => $timeout];
	$updates = endpoint('getUpdates', $content);
        if ($update) {
            if (count($this->updates['result']) >= 1) { //for CLI working.
                $last_element_id = $this->updates['result'][count($this->updates['result']) - 1]['update_id'] + 1;
                $content = ['offset' => $last_element_id, 'limit' => '1', 'timeout' => $timeout];
                $this->endpoint('getUpdates', $content);
            }
        }

        return $this->updates;
}

function endpoint($api, array $content, $post = true)
    {
        $url = 'https://api.telegram.org/bot'.$this->bot_token.'/'.$api;
        if ($post) {
            $reply = $this->sendAPIRequest($url, $content);
        } else {
            $reply = $this->sendAPIRequest($url, [], false);
        }
        return json_decode($reply, true);
    }
	
	


function sendAPIRequest($url, array $content, $post = true)
    {
        if (isset($content['chat_id'])) {
            $url = $url.'?chat_id='.$content['chat_id'];
            unset($content['chat_id']);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
		echo "inside curl if";
		if (!empty($this->proxy)) {
			echo "inside proxy if";
			if (array_key_exists("type", $this->proxy)) {
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy["type"]);
			}
			
			if (array_key_exists("auth", $this->proxy)) {
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy["auth"]);
			}
			
			if (array_key_exists("url", $this->proxy)) {
				echo "Proxy Url";
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy["url"]);
			}
			
			if (array_key_exists("port", $this->proxy)) {
				echo "Proxy port";
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy["port"]);
			}
			
		}
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        if ($result === false) {
            $result = json_encode(['ok'=>false, 'curl_error_code' => curl_errno($ch), 'curl_error' => curl_error($ch)]);
        }
		echo $result;
        curl_close($ch);
        if ($this->log_errors) {
            if (class_exists('TelegramErrorLogger')) {
                $loggerArray = ($this->getData() == null) ? [$content] : [$this->getData(), $content];
                TelegramErrorLogger::log(json_decode($result, true), $loggerArray);
            }
        }

        return $result;
    }
}



function send_get_message($url){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
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
	$url="https://api.telegram.org/bot609116902:AAHT0wmU_k1ICQ6s3aLQBpaoEUy4CDSXhcY/sendMessage?chat_id=613744501&text=".$text;
	echo $curl;
	//$url="https://api.telegram.org/".$bot_api_key."/sendMessage?chat_id=613744501&text=".$text;
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